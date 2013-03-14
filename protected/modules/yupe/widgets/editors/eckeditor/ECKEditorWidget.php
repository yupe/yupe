<?php

/*
 * 
 * Description of ECKEditor
 * 
 * @author Matt Saragusa <polyhedron@gmail.com>
 * 
 * v 0.1
 * 
 * /brief A class than can be used to create ckeditor instances in Yii
 * 
 * sample useage
 * 
 * $this->widget('application.extensions.eckeditor.ECKEditor', array(
 *               'model'=>$model,
 *               'column'=>'content',
 *               'language'=>'en',
 *               'toolbar'=>'full',
 *               ));
 */

require_once 'ECKEdit5.php';

class ECKEditorWidget extends CInputWidget{
    
    private $ECKE;
    private $_config = array();

    public $options;


    public function init() {
        
        parent::init();
        $this->ECKE = new ECKEdit5;

    }
    
    // Takes in configuration data from widget declaration and overrides any default settings
    public function setConfig($value){
        if(is_array($value) && count($value) > 0){
            foreach($value as $key => $value){
                $this->_config[$key] = $value;
             
            }
        }
    }


    public function run() {
        parent::run();
        
        // Saves $id will be the id of the element that ckeditor will target
        list($name, $id) = $this->resolveNameID();
        
        // Publish assets to public directory
        $baseDir = dirname(__FILE__);
        $assets = Yii::app()->getAssetManager()->publish($baseDir.DIRECTORY_SEPARATOR.'assets');
        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile($assets.'/ckeditor.js');
        
        echo CHtml::activeTextArea($this->model,  $this->attribute ,array('rows'=>10, 'cols'=>70));
        
        $this->ECKE->replace($id, $this->_config);
    }
}
?>
