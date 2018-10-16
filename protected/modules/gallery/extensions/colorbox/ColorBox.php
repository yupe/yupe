<?php

/**
 * Виджет отрисовки галереи изображений через colorbox
 *
 * @category YupeWidget
 * @package  yupe.modules.gallery.extensions.colorbox
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/
class ColorBox extends yupe\widgets\YWidget
{
    public $id;
    public $target;
    public $lang;
    public $config = [];

    public function init()
    {
        if (!isset($this->id)) {
            $this->id = $this->getId();
        }

        if (!isset($this->lang)) {
            $this->lang = Yii::app()->language;
        }

        $this->publishAssets();
    }

    public function run()
    {
        $config = CJavaScript::encode($this->config);
        Yii::app()->clientScript->registerScript(
            $this->getId(),
            "$('$this->target').colorbox($config);"
        );
    }

    public function publishAssets()
    {
        $assets = dirname(__FILE__) . '/assets';
        $baseUrl = Yii::app()->assetManager->publish($assets);

        if (is_dir($assets)) {
            Yii::app()->clientScript->registerCoreScript('jquery');
            Yii::app()->clientScript->registerCssFile($baseUrl . '/css/colorbox.css');
            Yii::app()->clientScript->registerScriptFile(
                $baseUrl . '/js/jquery.colorbox-min.js',
                CClientScript::POS_END
            );
            Yii::app()->clientScript->registerScriptFile(
                $baseUrl . '/js/i18n/jquery.colorbox-' . $this->lang . '.js',
                CClientScript::POS_END
            );
        } else {
            throw new Exception(Yii::t('GalleryModule.gallery', 'Catalog with assets not found!'));
        }
    }
}
