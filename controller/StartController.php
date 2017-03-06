<?php

namespace controller;

use view\StartView;
use model\Converts;
use model\BrowserInputs;

/**
 * Class Start
 * @package controller
 */
class StartController
{
    private $demo = false;
    /**
     * Init script for demonstration
     */
    public function init()
    {
        $json = '';
        $error = '';
        $xml = BrowserInputs::getPostValue('xml');
        if (!empty($xml)) {
            $model = new Converts();
            $json = $model->convertXmlStringToJsonString($xml);
            if ($json === '') {
                $error = $model->error;
            }
        } else {
            $xml = $this->getDemo();
            $this->demo = true;
        }
        StartView::renderInputXml($xml, $json, $error, $this->demo);
    }

    /**
     * Get demo xml
     * @return string
     */
    private function getDemo()
    {
        return '<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE recipe>
<recipe name="хлеб" preptime="5min" cooktime="180min">
   <title>
      Простой хлеб
   </title>
   <composition>
      <ingredient amount="3" unit="стакан">Мука</ingredient>
      <ingredient amount="0.25" unit="грамм">Дрожжи</ingredient>
      <ingredient amount="1.5" unit="стакан">Тёплая вода</ingredient>
   </composition>
   <instructions>
     <step>
        Смешать все ингредиенты и тщательно замесить.
     </step>
     <step>
        Закрыть тканью и оставить на один час в тёплом помещении.
     </step>
     <!--
        <step>
           Почитать вчерашнюю газету.
        </step>
         - это сомнительный шаг...
      -->
     <step>
        Замесить ещё раз, положить на противень и поставить в духовку.
     </step>
   </instructions>
</recipe>';
    }
}