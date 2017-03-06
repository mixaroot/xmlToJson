<?php

namespace components\xml\helpers;
/**
 * Class XmlHelper
 * @package components\xml\helpers
 */
class StringHelper
{
    /**
     * @param string $xml
     * @return string
     */
    public static function deleteNewLine(string $xml): string
    {
        return str_replace(["\n", "\r"], '', $xml);
    }

    /**
     * @param string $xml
     * @return string
     */
    public static function deleteSpaces(string $xml): string
    {
        return trim(preg_replace('/\s\s+/', ' ', $xml));
    }

    /**
     * @param string $xml
     * @return string
     */
    public static function deleteXmlComments(string $xml): string
    {
        return trim(preg_replace('/<\!--.*-->/', '', $xml));
    }

    /**
     * @param string $attributes
     * @return array
     */
    public static function splitBySpaces(string $attributes): array
    {
        return preg_split('/[\s]+/', $attributes);
    }

    /**
     * @param string $item
     * @return string
     */
    public static function deleteQuotes(string $item): string
    {
        return trim($item, '\'"');
    }

}