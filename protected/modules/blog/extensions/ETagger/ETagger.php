<?php

/**
 * Yii extension wrapping the jQuery UI Tagger Widget from Samuel Chavez
 * {@link https://github.com/samuelchvez/jQuery-Tagger}
 * 
 * @author Dennis <dinix@gmx.com>
 *
 */
Yii::import('zii.widgets.jui.CJuiInputWidget');

/**
 * Base class
 */
class ETagger extends CJuiInputWidget
{
     /**
     * @var CModel the data model associated with this widget.
     */
    public $model;
    /**
     * @var string the attribute associated with this widget.
     */
    public $attribute;    
    /**
     * @var string the separator for the keywords.
     */
    public $separator = ',';
    /**
     * @var string the name of the input field. This must be set if {@link model} is not set.
     */
    public $name = '';
    /**
     * @var array data for filling the default values. This must be set if {@link model} is not set.
     */
    public $keywords = array();
    /**
     * @var string width of the resulting element
     */
    public $width = "";    
    /**
     * @var int number of tags to be alowed
     */
    public $limit = -1;
    /**
     * @var string Name of the CSS class to be applied to each tag (span element)
     */    
    public $tagClass = "tag";
    /**
     * @var string Name of the CSS class to be applied to each tag (span element)
     */
    public $taggerWrapperClass = "tagger-input-container";
    
    /**
     * @var array options for the jQuery UI Tagger Widget
     */
    public $options = array();
    /**
     * @var array additional HTML attributes for the text input (NOT for the wrapper div)
     */
    public $inputOptions = array();
    /**
     * @var boolean use default css file
     */
    public $useDefaultCSS = true;

    public function init()
    {
        $options = array(
            'separator'=>$this->separator,
            'tagClass'=>$this->tagClass,
            'taggerWrapperClass'=>$this->taggerWrapperClass,
            'width'=>$this->width,
        );
        if ($this->limit >= 0) 
            $options['limit'] = $this->limit;
        

        $this->options = array_merge($options, $this->options);
        
        $cs = Yii::app()->getClientScript();
        $assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . '/assets');
        $cs->registerCoreScript('jquery');
        $cs->registerCoreScript('jquery.ui');
        $cs->registerScriptFile($assets . '/jquery.tagger.js');
        if ($this->useDefaultCSS)
            $cs->registerCssFile($assets . '/main.css');
        
        parent::init();
    }

    /**
     * Run this widget.
     * Registers necessary javascript and renders the needed HTML code.
     */
    public function run()
    {
        list($name, $id) = $this->createIdentifiers();
        // Render drop-down element and hide it with javascript
        if ($this->hasModel())
            echo CHtml::activeTextField($this->model, $this->attribute, $this->inputOptions);
        else
            echo CHtml::textField($name, implode($this->separator,$this->keywords), $this->inputOptions);     

        $joptions=CJavaScript::encode($this->options);
        $jscode = "jQuery('#{$id}').tagger({$joptions});";
        Yii::app()->getClientScript()->registerScript(__CLASS__ . '#' . $id, $jscode);
    }
    
    
    
    /**
     * @return array the name and the ID
     */
    protected function createIdentifiers()
    {
        $name_id = array();
        if($this->name && !empty($this->name)) {
            $name=$this->name;
        }
        else if($this->hasModel()) {
            $name=CHtml::activeName($this->model,$this->attribute);
            CHtml::resolveNameID($this->model, $this->attribute, $name_id);
        }
        else {
            throw new CException(Yii::t('application','{class} must specify "model" and "attribute" or "name" property values.',array('{class}'=>get_class($this))));
        }

        if(isset($this->inputOptions['id'])) {
            $id=$this->inputOptions['id'];
        }
        else if(!empty($name_id['id'])) {
            $id=$name_id['id'];
        }
        else {
            $id=CHtml::getIdByName($name);
        }

        return array($name,$id);
    }
    
    /**
     * @return boolean whether this widget is associated with a data model.
     */
    protected function hasModel()
    {
        return ($this->model instanceof CModel) && !empty($this->attribute);
    }
}
