<?php

/**
 * Highlightjs.php Компонент подключающий библиотеку Highlight.js
 *
 * @author Anton Kucherov <idexter.ru@gmail.com>
 * @link http://idexter.ru/
 * @copyright 2013 idexter.ru
 */
class Highlightjs extends CComponent
{
    /**
     * @var string Путь к файлам библиотеки
     */
    public $assetsPath = 'application.modules.yupe.extensions.highlightjs.assets';

    /**
     * @var bool Загружать локальную копию highlight.js или удаленную с yandet.st
     */
    public $remote = false;

    /**
     * @var string Стиль оформления кода
     */
    public $style = 'default';

    /**
     * @var string Версия библиотеки при использовании опции $remote
     */
    public $version = '7.3';

    private $_js;
    private $_css;

    /**
     * Инициализация компонента
     */
    public function init()
    {
        $assetsPath = Yii::getPathOfAlias($this->assetsPath);

        $this->_js = Yii::app()->getAssetManager()->publish($assetsPath . DIRECTORY_SEPARATOR . 'highlight.pack.js');
        $this->_css = Yii::app()->getAssetManager()->publish(
            $assetsPath . DIRECTORY_SEPARATOR . '/styles/' . $this->style . '.css'
        );

        if ($this->remote === true) {
            $this->_css = "http://yandex.st/highlightjs/{$this->version}/styles/{$this->style}.min.css";
            $this->_js = "http://yandex.st/highlightjs/{$this->version}/highlight.min.js";
        }

    }

    /**
     * Метод регистрирует и загружает скрипты необходимые для работы Highlight.js
     */
    public function loadClientScripts()
    {
        $clientScript = Yii::app()->clientScript;

        $clientScript->registerCssFile($this->_css);
        $clientScript->registerScriptFile($this->_js);
        $clientScript->registerScript('hightlightjs', "hljs.initHighlightingOnLoad();");
    }
}
