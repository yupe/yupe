<?php

use yupe\widgets\YWidget;

/**
 * Class ColorBoxWidget
 */
class ColorBoxWidget extends YWidget
{
    /**
     * @var
     */
    private $assetsUrl;

    /**
     * @var
     */
    public $targets;

    /**
     *
     */
    public function init()
    {
        $this->assetsUrl = Yii::app()->getAssetManager()->publish(__DIR__ . '/assets');

        Yii::app()->getClientScript()->registerScriptFile(
            $this->assetsUrl . '/js/jquery.colorbox-min.js'
        );

        Yii::app()->getClientScript()->registerCssFile(
            $this->assetsUrl . '/colorbox.css'
        );

        parent::init();
    }

    /**
     *
     */
    public function run()
    {
        if (!empty($this->targets)) {
            $script = '';
            foreach ($this->targets as $selector => $options) {
                $options = CJavaScript::encode($options);
                $script .= "$('{$selector}').colorbox({$options});" . PHP_EOL;
            }
            Yii::app()->getClientScript()->registerScript(__CLASS__, $script, CClientScript::POS_READY);
        }
    }
} 
