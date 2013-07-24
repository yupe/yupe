<?php
/**
 * Обрамляет изображение в рамку, фиксируя его по центру.
 */
class ImageWrapper extends CWidget
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

    public $htmlOptions = array();
    
    public function run() {
        if(!$this->height) {
            $this->height = $this->width;
        }
        
        Yii::app()->clientScript->registerCss('ImageWrapper', "
            .img-wrapper-tocenter {
                display: table-cell;
                text-align: center;
                vertical-align: middle;
                /*width: 100px;
                height: 100px;
                background-color: black;*/
            }
            .img-wrapper-tocenter * {
                vertical-align: middle;
            }
            /*\*//*/
            .img-wrapper-tocenter {
                display: block;
            }
            .img-wrapper-tocenter span {
                display: inline-block;
                height: 100%;
                width: 1px;
            }
            /**/
        ");
        
        $htmlOptions = array(
            'class' => 'img-wrapper-tocenter',
            'style' => 'width: ' . $this->width . '; height: ' . $this->height . '; background-color: '. $this->backgroundColor .';',
        );
        
        if(isset($this->htmlOptions['class'])) {
            $class = $this->htmlOptions['class'];
            unset($this->htmlOptions['class']);
            $htmlOptions['class'] .= ' ' . $class;
        }
        
        if(isset($this->htmlOptions['style'])) {
            $style = $this->htmlOptions['style'];
            unset($this->htmlOptions['style']);
            $htmlOptions['style'] .= ' ' . $style;
        }
        
        if(is_array($this->htmlOptions) && count($this->htmlOptions) > 0)
            $htmlOptions = array_merge($htmlOptions, $this->htmlOptions);
        
        echo CHtml::tag('div', $htmlOptions, '<span></span>' . CHtml::image($this->imageSrc,  $this->imageAlt));
    }
}