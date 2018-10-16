<?php

/**
 * Обрамляет изображение в рамку, фиксируя его по центру.
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.image.widgets
 * @since 0.1
 *
 */
use yupe\widgets\YWidget;

class ImageWrapper extends YWidget
{
    public $width = '100px';
    /**
     * Для достаточно указать только $width
     * @var string
     */
    public $height;
    /**
     * Цвет рамки
     * @var string
     */
    public $backgroundColor = '#000';
    /**
     * URL изображения, помещаемого в рамку
     * @var string
     */
    public $imageSrc;
    /**
     * Альтернативный текст изображения
     * @var string
     */
    public $imageAlt = '';
    /**
     * Если истина - предотвращает кэширование добавлением значения microtime()
     * к src изображения
     * @var boolean
     */
    public $noCache = false;

    public $htmlOptions = [];

    public function run()
    {
        if (!$this->height) {
            $this->height = $this->width;
        }

        Yii::app()->clientScript->registerCssFile(
            Yii::app()->assetManager->publish(
                Yii::getPathOfAlias('image.widgets.assets') . '/image-wrapper.css'
            )
        );

        $htmlOptions = [
            'class' => 'img-wrapper-tocenter',
            'style' => 'width: ' . $this->width . '; height: ' . $this->height . '; background-color: ' . $this->backgroundColor . ';',
        ];

        if (isset($this->htmlOptions['class'])) {
            $class = $this->htmlOptions['class'];
            unset($this->htmlOptions['class']);
            $htmlOptions['class'] .= ' ' . $class;
        }

        if (isset($this->htmlOptions['style'])) {
            $style = $this->htmlOptions['style'];
            unset($this->htmlOptions['style']);
            $htmlOptions['style'] .= ' ' . $style;
        }

        if (is_array($this->htmlOptions) && count($this->htmlOptions) > 0) {
            $htmlOptions = array_merge($htmlOptions, $this->htmlOptions);
        }

        echo CHtml::tag(
            'div',
            $htmlOptions,
            '<span></span>' . CHtml::image($this->imageSrc . ($this->noCache ? '?' . microtime() : ''), $this->imageAlt)
        );
    }
}
