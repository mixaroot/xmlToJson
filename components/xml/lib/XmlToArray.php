<?php

namespace components\xml\lib;

use components\xml\interfaces\ValidationXmlElementInterface;
use components\xml\helpers\StringHelper;
use components\xml\exception\ExceptionXmlConvert;

/**
 * Convert xml string to array
 * Class XmlToArray
 * @package components\xml\lib
 */
class XmlToArray
{
    const START_TAG = 1;
    const CONTENT = 2;
    const END_TAG = 3;

    const SECURITY_LIMIT = 10000;
    /**
     * xml string
     * @var string|string
     */
    private $xml = '';
    /**
     * Object for validation xml parts
     * @var ValidationXmlElementInterface|null
     */
    private $oValidation = null;
    /**
     * Version of xml
     * @var bool
     */
    private $version = false;
    /**
     * encoding of xml
     * @var bool
     */
    private $encoding = false;
    /**
     * @var bool
     */
    private $standalone = false;
    /**
     * @var bool
     */
    private $docType = false;
    /**
     * Array of links for transfer xml to array
     * @var array
     */
    private $levelLinks = [];
    /**
     * Result of transfer xml to array
     * @var array
     */
    private $array = [];

    /**
     * @param string $xml
     * @param ValidationXmlElementInterface $oValidation
     */
    public function __construct(string $xml, ValidationXmlElementInterface $oValidation)
    {
        $this->xml = $xml;
        $this->oValidation = $oValidation;
    }

    /**
     * Convert xml to array
     */
    public function convert()
    {
        $this->preparingXmlString();
        $this->parseDeclaration();
        $this->setDocType();
        $this->parseBody();
        return $this->array;
    }

    /**
     * Preparing xml string (delete comments, new line, etc)
     */
    private function preparingXmlString()
    {
        $this->xml = StringHelper::deleteNewLine($this->xml);
        $this->xml = StringHelper::deleteSpaces($this->xml);
        $this->xml = StringHelper::deleteXmlComments($this->xml);
    }

    /**
     * Parse header
     * @throws ExceptionXmlConvert
     */
    private function parseDeclaration()
    {
        if (preg_match('/^<\?xml\s(.*?)\?\>/', $this->xml, $match)) {
            if (!empty($match[1])) {
                $attributes = $this->getArrayOfAttributes(trim($match[1]));
                $this->setDocumentProperties($attributes);
            }
            $this->deleteElementFromStartString($match[0]);
        } else {
            throw new ExceptionXmlConvert(ExceptionXmlConvert::ERROR_WRONG_DECLARATION);
        }
    }

    /**
     * Get attributes
     * @param $attributes
     * @return array
     */
    private function getArrayOfAttributes($attributes)
    {
        $attributes = StringHelper::splitBySpaces($attributes);
        $result = [];
        if (is_array($attributes)) {
            $result = $this->parseArrayOfAttributes($attributes);
        }
        return $result;
    }

    private function parseArrayOfAttributes($attributes)
    {
        $result = [];
        foreach ($attributes as $attribute) {
            $attribute = $this->getAttribute($attribute);
            if (!empty($attribute)) {
                if (!empty($result[$attribute['name']])) {
                    throw new ExceptionXmlConvert(ExceptionXmlConvert::ERROR_DUPLICATE_ATTRIBUTE_NAME);
                }
                $result[$attribute['name']] = StringHelper::deleteQuotes($attribute['value']);
            }
        }
        return $result;
    }

    /**
     * @param $attribute
     * @return array
     * @throws ExceptionXmlConvert
     */
    private function getAttribute($attribute)
    {
        $values = explode('=', $attribute, 2);
        if (count($values) !== 2 ||
            !$this->oValidation->checkAttributeName($values[0]) ||
            !$this->oValidation->checkAttributeValue($values[1])
        ) {
            throw new ExceptionXmlConvert(ExceptionXmlConvert::ERROR_WRONG_ATTRIBUTE);
        }
        return [
            'name' => $values[0],
            'value' => $values[1]
        ];
    }

    /**
     * @param $attributes
     */
    private function setDocumentProperties($attributes)
    {
        if (!empty($attributes['version'])) {
            $this->version = $attributes['version'];
        }
        if (!empty($attributes['encoding'])) {
            $this->encoding = $attributes['encoding'];
        }
        if (!empty($attributes['standalone'])) {
            $this->standalone = $attributes['standalone'];
        }
    }

    /**
     * Delete parsed value from string
     * @param $element
     */
    private function deleteElementFromStartString($element)
    {
        $length = mb_strlen($element);
        $this->xml = mb_substr($this->xml, $length);
    }

    /**
     * Set doc type
     */
    private function setDocType()
    {
        if (preg_match('/<\!DOCTYPE\s(.+?)>/', $this->xml, $match)) {
            if (!empty($match[1])) {
                if (!$this->oValidation->checkAttributeName($match[1])) {
                    throw new ExceptionXmlConvert(ExceptionXmlConvert::ERROR_WRONG_ATTRIBUTE);
                }
            }
            $this->docType = $match[1];
            $this->deleteElementFromStartString($match[0]);
        }
    }

    /**
     * Parse main xml content
     * @throws ExceptionXmlConvert
     */
    private function parseBody()
    {
        if (!$this->oValidation->checkBodySize($this->xml)) {
            throw new ExceptionXmlConvert(ExceptionXmlConvert::ERROR_WRONG_START_TAG_IN_BODY);
        }
        $this->levelLinks[] = &$this->array;
        $i = 0;
        while (mb_strlen($this->xml) > 0) {
            if ($i > static::SECURITY_LIMIT) {
                throw new ExceptionXmlConvert(ExceptionXmlConvert::LIMIT_ITERATION . static::SECURITY_LIMIT);
            }
            $this->parseBodyElement();
            $i++;
        }
        unset($this->levelLinks[$this->getLastKeyLinks()]);
        if (!empty($this->levelLinks)) {
            throw new ExceptionXmlConvert(ExceptionXmlConvert::WRONG_OPEN_CLOSE_TAG);
        }
    }

    /**
     * Parse all type of xml document
     */
    private function parseBodyElement()
    {
        $this->xml = trim($this->xml);
        $type = $this->getContentType();
        switch ($type) {
            case (static::START_TAG):
                $this->workStartTag();
                break;
            case (static::CONTENT):
                $this->workContent();
                break;
            case (static::END_TAG):
                $this->workEndTag();
                break;
        }
    }

    /**
     * Parse open xml tag
     * @throws ExceptionXmlConvert
     */
    private function workStartTag()
    {
        if (preg_match('/^<(.*?)>/', $this->xml, $match)) {
            if (empty($match[1])) {
                throw new ExceptionXmlConvert(ExceptionXmlConvert::ERROR_HAVE_NOT_TAG_NAME);
            }
            $values = StringHelper::splitBySpaces($match[1]);
            if (!$this->oValidation->checkTagName($values[0])) {
                throw new ExceptionXmlConvert(ExceptionXmlConvert::WRONG_TAG_NAME);
            }
            $key = $this->getLastKeyLinks();
            $duplicateKey = 0;
            if (!isset($this->levelLinks[$key][$values[0]])) {
                $this->levelLinks[$key][$values[0]] = [];
            } else {
                end($this->levelLinks[$key][$values[0]]);
                $duplicateKey = count($this->levelLinks[$key][$values[0]]);
            }
            $this->levelLinks[] = &$this->levelLinks[$key][$values[0]][$duplicateKey];
            $attributes = array_slice($values, 1);
            if (!empty($attributes)) {
                $attributes = $this->parseArrayOfAttributes($attributes);
                $this->levelLinks[$this->getLastKeyLinks()]['#attributes'] = $attributes;
            }
            $this->deleteElementFromStartString($match[0]);
        } else {
            throw new ExceptionXmlConvert(ExceptionXmlConvert::ERROR_WRONG_START_TAG);
        }
    }

    /**
     * Parse content
     * @throws ExceptionXmlConvert
     */
    private function workContent()
    {
        if (preg_match('/^(.*?)</', $this->xml, $match)) {
            if (!empty($match[1])) {
                if (!$this->oValidation->checkTagContent($match[1])) {
                    throw new ExceptionXmlConvert(ExceptionXmlConvert::WRONG_CONTENT);
                }
                $this->levelLinks[$this->getLastKeyLinks()]['#body'] = $match[1];
                $this->deleteElementFromStartString($match[1]);
            }
        } else {
            throw new ExceptionXmlConvert(ExceptionXmlConvert::WRONG_CONTENT);
        }
    }

    /**
     * Parse close tag
     * @throws ExceptionXmlConvert
     */
    private function workEndTag()
    {
        if (preg_match('/^<\/(.*?)>/', $this->xml, $match)) {
            if (!empty($match[1])) {
                if (!$this->oValidation->checkTagName($match[1])) {
                    throw new ExceptionXmlConvert(ExceptionXmlConvert::WRONG_TAG_NAME);
                }
                unset($this->levelLinks[$this->getLastKeyLinks()]);
                $this->deleteElementFromStartString($match[0]);
            }
        } else {
            throw new ExceptionXmlConvert(ExceptionXmlConvert::WRONG_TAG_NAME);
        }
    }

    /**
     * Get last key in stack of links
     * @return mixed
     */
    private function getLastKeyLinks()
    {
        end($this->levelLinks);
        return key($this->levelLinks);
    }

    /**
     * Get type of data
     * @return int
     */
    private function getContentType()
    {
        if ($this->xml[0] === '<') {
            if ($this->xml[1] === '/') {
                return static::END_TAG;
            }
            return static::START_TAG;
        }
        return static::CONTENT;
    }

}