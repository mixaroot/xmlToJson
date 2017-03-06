<?php

namespace components\xml\init;

use components\xml\lib\CreateJsonString;
use components\xml\lib\ValidationXmlElement;
use components\xml\lib\XmlToArray;
use components\xml\lib\ArrayToJson;

/**
 * Convert xml string to json string
 * Class XmlStringToJsonString
 * @package components\xml\init
 */
class XmlStringToJsonString
{
    /**
     * @param string $xml
     * @return mixed
     */
    public function start(string $xml)
    {
        $xmlToArray = new XmlToArray($xml, new ValidationXmlElement());
        $array = $xmlToArray->convert();
        $arrayToJson = new ArrayToJson($array, new CreateJsonString());
        return $arrayToJson->convert();
    }
}