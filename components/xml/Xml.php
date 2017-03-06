<?php

namespace components\xml;

use components\xml\init\XmlStringToJsonString;
use components\xml\exception\ExceptionXmlConvert;

/**
 * Class Xml
 * @package components\xml
 */
class Xml
{
    /**
     * @var string
     */
    private $json = '';
    /**
     * @var string
     */
    private $error = '';

    /**
     * @return string
     */
    public function getJson()
    {
        return $this->json;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param $xml
     */
    public function convertXmlStringToJsonString($xml)
    {
        try {
            $this->validationInputXml($xml);
            $converter = new XmlStringToJsonString();
            $this->json = $converter->start($xml);
        } catch (ExceptionXmlConvert $e) {
            $this->error = $e->getMessage();
        }

    }

    /**
     * @param $xml
     * @throws ExceptionXmlConvert
     */
    private function validationInputXml($xml)
    {
        if (empty($xml)) {
            throw new ExceptionXmlConvert(ExceptionXmlConvert::EMPTY_XML_STRING);
        }
        if (!is_string($xml)) {
            throw new ExceptionXmlConvert(ExceptionXmlConvert::XML_MUST_BE_STRING);
        }
    }
}