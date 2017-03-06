<?php

namespace components\xml\interfaces;
/**
 * Interface for create json
 * Interface CreateJsonInterface
 * @package components\xml\interfaces
 */
interface CreateJsonInterface
{
    /**
     * Create start json mark, as rule {
     * @return mixed
     */
    public function startCurlyQuotationMark();

    /**
     * Create end json mark, as rule }
     * @return mixed
     */
    public function endCurlyQuotationMark();

    /**
     * Add tag name to json
     * @param string $name
     * @return mixed
     */
    public function tagName(string $name);

    /**
     * Add tag attributes to json
     * @param array $attributes
     * @return mixed
     */
    public function tagAttributes(array $attributes);

    /**
     * Add tag body to json
     * @param string $body
     * @return mixed
     */
    public function tagBody(string $body);

    /**
     * Add comma to json
     * @return mixed
     */
    public function comma();

    /**
     * Create start json mark, as rule [
     * @return mixed
     */
    public function startSquareBrackets();

    /**
     * Create end json mark, as rule ]
     * @return mixed
     */
    public function endSquareBrackets();

    /**
     * Get result json, maybe string, maybe file, ...
     * @return mixed
     */
    public function getJson();
}