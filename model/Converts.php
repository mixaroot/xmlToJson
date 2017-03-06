<?php

namespace model;

use components\xml\Xml;

/**
 * Class Converts
 * @package model
 */
class Converts
{
    /**
     * @var string
     */
    public $error = '';

    /**
     * Convert xml string to json string
     * @param string $xml
     * @return bool|string
     */
    public function convertXmlStringToJsonString(string $xml)
    {
        $xmlComponent = new Xml();
        $xmlComponent->convertXmlStringToJsonString($xml);
        $error = $xmlComponent->getError();
        if (!empty($error)) {
            $this->error = $error;
            return '';
        }
        return $xmlComponent->getJson();
    }
}