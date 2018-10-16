<?php

/*
 * Виджет для вывода аватарки
 */

/**
 * Class AvatarWidget
 */
class AvatarWidget extends CWidget
{
    /**
     * @var string
     */
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

    /**
     * @var array
     */
    public $htmlOptions = [];

    /**
     * @var array
     */
    public $imageHtmlOptions = [];

    /**
     * Модель пользователя
     * @var User
     */
    public $user;

    /**
     * Размер аватарки
     * @var int Пикселей
     */
    public $size = 100;

    /**
     * @throws CException
     */
    public function run()
    {
        $this->imageSrc = $this->user->getAvatar($this->size);
        $this->imageAlt = $this->user->nick_name;
        $this->width = $this->size.'px';
        $this->htmlOptions = ['class' => 'avatar avatar-'.$this->user->id];

        if (!$this->height) {
            $this->height = $this->width;
        }

        Yii::app()->clientScript->registerCssFile(
            Yii::app()->assetManager->publish(
                Yii::getPathOfAlias('user.assets.css').'/image-wrapper.css'
            )
        );

        $htmlOptions = [
            'class' => 'img-wrapper-tocenter',
            'style' => 'width: '.$this->width.'; height: '.$this->height.'; background-color: '.$this->backgroundColor.';',
        ];

        if (isset($this->htmlOptions['class'])) {
            $class = $this->htmlOptions['class'];
            unset($this->htmlOptions['class']);
            $htmlOptions['class'] .= ' '.$class;
        }

        if (isset($this->htmlOptions['style'])) {
            $style = $this->htmlOptions['style'];
            unset($this->htmlOptions['style']);
            $htmlOptions['style'] .= ' '.$style;
        }

        if (is_array($this->htmlOptions) && count($this->htmlOptions) > 0) {
            $htmlOptions = array_merge($htmlOptions, $this->htmlOptions);
        }

        echo CHtml::tag(
            'div',
            $htmlOptions,
            CHtml::image(
                $this->imageSrc.($this->noCache ? '?'.microtime(true) : ''),
                $this->imageAlt,
                $this->imageHtmlOptions
            )
        );
    }
}
