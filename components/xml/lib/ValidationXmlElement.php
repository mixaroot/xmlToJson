<?php

namespace components\xml\lib;

use components\xml\interfaces\ValidationXmlElementInterface;

/**
 * Class ValidationXmlElement
 * @package components\xml\lib
 */
class ValidationXmlElement implements ValidationXmlElementInterface
{
    /**
     * TODO решил что для тестового задания будет достаточно заглушки
     * TODO здесь нужна проверка на допустимые значения имени атрибута
     * @inheritdoc
     */
    public function checkAttributeName(string $name):bool
    {
        //TODO something ...
        return true;
    }

    /**
     * TODO решил что для тестового задания будет достаточно заглушки
     * TODO здесь нужна проверка на допустимые значения содержания атрибута
     * @inheritdoc
     */
    public function checkAttributeValue(string $value):bool
    {
        //TODO something ...
        return true;
    }

    /**
     * @inheritdoc
     */
    public function checkBodySize(string $xml):bool
    {
        if (mb_strlen($xml) < 3) {
            return false;
        }
        return true;
    }

    /**
     * TODO решил что для тестового задания будет достаточно заглушки
     * TODO здесь нужна проверка на допустимые значения имени тега
     * @inheritdoc
     */
    public function checkTagName(string $name):bool
    {
        //TODO something ...
        return true;
    }

    /**
     * TODO решил что для тестового задания будет достаточно заглушки
     * TODO здесь нужна проверка на допустимые значения содержания тега
     * @inheritdoc
     */
    public function checkTagContent(string $content):bool
    {
        //TODO something ...
        return true;
    }
}