<?php

namespace components\xml\lib;

use components\xml\interfaces\CreateJsonInterface;

/**
 * Class ArrayToJson
 * @package components\xml\lib
 */
class ArrayToJson
{
    const BODY = '#body';
    const ATTRIBUTES = '#attributes';
    /**
     * Result of transfer xml to array
     * @var array
     */
    private $array = [];
    /**
     * Object for write to json
     * @var CreateJsonInterface|null
     */
    private $oJson = null;

    /**
     * @param array $array
     * @param CreateJsonInterface $oJson
     */
    public function __construct(array $array, CreateJsonInterface $oJson)
    {
        $this->array = $array;
        $this->oJson = $oJson;
    }

    /**
     * Convert array to json
     * @return mixed
     */
    public function convert()
    {
        $this->initArrayToJson();
        return $this->oJson->getJson();
    }

    /**
     * Initialization to write elements to json
     */
    private function initArrayToJson()
    {
        $this->oJson->startCurlyQuotationMark();
        $this->arrayToJson($this->array);
        $this->oJson->endCurlyQuotationMark();

    }

    /**
     * Start to write elements to json
     * @param array $elements
     */
    private function arrayToJson(array $elements)
    {
        foreach ($elements as $name => $items) {
            if (is_string($name)) {
                $this->oJson->comma();
                if (is_string($name)) {
                    $this->oJson->tagName($name);
                }
                $this->writeTags($items);
            }
        }
    }

    /**
     * Write few tags to json
     * @param array $tags
     */
    private function writeTags(array $tags)
    {
        $countElement = count($tags);
        if ($countElement > 1) {
            $this->oJson->startSquareBrackets();
            foreach ($tags as $tag) {
                $this->writeTag($tag);
            }
            $this->oJson->endSquareBrackets();
        } elseif ($countElement === 1) {
            $this->writeTag($tags[0]);
        }
    }

    /**
     * Write one tag to json
     * @param array $tag
     */
    private function writeTag(array $tag)
    {
        $isSimple = $this->checkIsSimpleTag($tag);
        if (!$isSimple) {
            $this->oJson->comma();
            $this->oJson->startCurlyQuotationMark();
        }
        if (!empty($tag[static::ATTRIBUTES])) {
            $this->oJson->tagAttributes($tag[static::ATTRIBUTES]);
            unset($tag[static::ATTRIBUTES]);
        }
        if (!empty($tag[static::BODY])) {
            if ($isSimple) {
                $this->oJson->comma();
                $this->oJson->tagBody($tag[static::BODY]);
            } else {
                $this->oJson->comma();
                $this->oJson->tagName(static::BODY);
                $this->oJson->tagBody($tag[static::BODY]);
            }
            unset($tag[static::BODY]);
        }
        if (!empty($tag) && is_array($tag)) {
            //Recursion for next tags group
            $this->arrayToJson($tag);
        }
        if (!$isSimple) {
            $this->oJson->endCurlyQuotationMark();
        }
    }

    /**
     * Check tag to have only body or something else
     * @param array $tag
     * @return bool
     */
    private function checkIsSimpleTag(array $tag): bool
    {
        if (empty($tag[static::ATTRIBUTES]) && !empty($tag[static::BODY]) && count($tag) === 1) {
            return true;
        }
        return false;
    }
}