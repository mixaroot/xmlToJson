<?php

namespace components\xml\interfaces;
/**
 * Interface ValidationXmlElementInterface
 * @package components\xml\interfaces
 */
interface ValidationXmlElementInterface
{
    /**
     * Check allowed attribute name or not
     * @param string $name
     * @return bool
     */
    public function checkAttributeName(string $name): bool;

    /**
     * Check allowed attribute value or not
     * @param string $value
     * @return bool
     */
    public function checkAttributeValue(string $value): bool;

    /**
     * Check correct body size or not
     * @param string $xml
     * @return bool
     */
    public function checkBodySize(string $xml): bool;

    /**
     * Check allowed tag name or not
     * @param string $name
     * @return bool
     */
    public function checkTagName(string $name): bool;

    /**
     * Check allowed content or not
     * @param string $content
     * @return bool
     */
    public function checkTagContent(string $content): bool;
}