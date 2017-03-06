<?php

namespace view;
/**
 * Class StartView
 * @package view
 */
class StartView
{
    /**
     * Render textarea for input xml
     * @param string $xml
     * @param string $json
     * @param string $error
     * @param bool $demo
     */
    public static function renderInputXml(string $xml, string $json, string $error, bool $demo)
    {
        ?>
        <head>
            <script src="static/js/scripts.js"></script>
            <link rel="stylesheet" type="text/css" href="static/css/index.css">
        </head>
        <div id="error">
            <?= $error ?>
        </div>
        <?php
        if ($demo) {
            echo '<div class="green">Это xml для демонстрации: </div>';
        }
        ?>
        <form action="/" method="post">
            <p>
                <b>
                    Введите xml:
                </b>
            </p>

            <p>
                <textarea rows="30" cols="100" name="xml"><?= $xml ?></textarea>
            </p>

            <p>
                <input type="submit" value="Конвертировать">
            </p>
        </form>
        <div>
            <h3>JSON result: </h3>
            <span id="resultJson">
                <?= $json ?>
            </span>

            <h3>
                Pretty JSON result:
            </h3>
            <span id="prettyResultJson">
                <?= $json ?>
            </span>
        </div>
        <?php
    }
}