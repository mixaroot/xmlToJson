<?php

namespace model;
/**
 * Class BrowserInputs
 * @package model
 */
class BrowserInputs
{
    /**
     * @param string $name
     * @param mixed $defaultValue
     * @return mixed
     */
    public static function getPostValue(string $name, $defaultValue = false)
    {
        if (!empty($_POST[$name])) {
            return $_POST[$name];
        }
        return $defaultValue;
    }
}