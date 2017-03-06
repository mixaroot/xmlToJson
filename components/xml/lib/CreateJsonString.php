<?php

namespace components\xml\lib;

use components\xml\interfaces\CreateJsonInterface;

/**
 * Class for create json string
 * Class CreateJsonString
 * @package components\xml\lib
 */
class CreateJsonString implements CreateJsonInterface
{
    /**
     * Result
     * @var string
     */
    private $json = '';

    /**
     * @inheritdoc
     */
    public function startCurlyQuotationMark()
    {
        $this->json .= "{";
    }

    /**
     * @inheritdoc
     */
    public function endCurlyQuotationMark()
    {
        $this->json .= '}';
    }

    /**
     * @inheritdoc
     */
    public function tagName(string $name)
    {
        $this->json .= "\"$name\":";
    }

    /**
     * @inheritdoc
     */
    public function tagAttributes(array $attributes)
    {
        $attributesForAppend = [];
        foreach ($attributes as $attributeName => $attributeValue) {
            $attributesForAppend[] = "\"$attributeName\":\"$attributeValue\"";
        }
        $attributesForAppend = implode(",", $attributesForAppend);
        $this->json .= $attributesForAppend;
    }

    /**
     * @inheritdoc
     */
    public function tagBody(string $body)
    {
        $this->json .= "\"$body\"";
    }

    /**
     * @inheritdoc
     */
    public function comma()
    {
        if (!in_array(mb_substr($this->json, -1), ['{', '[', ':'])) {
            $this->json .= ',';
        }
    }

    /**
     * @inheritdoc
     */
    public function startSquareBrackets()
    {
        $this->json .= '[';
    }

    /**
     * @inheritdoc
     */
    public function endSquareBrackets()
    {
        $this->json .= ']';
    }

    /**
     * @inheritdoc
     * @return string
     */
    public function getJson(): string
    {
        return $this->json;
    }

}