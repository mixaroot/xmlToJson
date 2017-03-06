<?php

namespace components\xml\exception;
/**
 * Class ExceptionXmlConvert
 * @package components\xml\exception
 */
class ExceptionXmlConvert extends \Exception
{
    const EMPTY_XML_STRING = 'Empty xml string, please set xml string before run';
    const XML_MUST_BE_STRING = 'Xml must be string';
    const ERROR_WRONG_DECLARATION = 'Wrong xml declaration, please add something like: &lt;?xml version="1.0" encoding="utf-8"?&gt;';
    const ERROR_DUPLICATE_ATTRIBUTE_NAME = 'Duplicate attribute name';
    const ERROR_WRONG_ATTRIBUTE = 'Wrong attribute';
    const ERROR_WRONG_START_TAG_IN_BODY = 'wrong start tag in body';
    const ERROR_WRONG_START_TAG = 'wrong start tag';
    const ERROR_HAVE_NOT_TAG_NAME = 'have not tag name';
    const LIMIT_ITERATION = 'Iteration limit for security: ';
    const WRONG_TAG_NAME = 'Wrong tag name';
    const WRONG_CONTENT = 'Wrong content';
    const WRONG_OPEN_CLOSE_TAG = 'Wrong open or close tags';
}