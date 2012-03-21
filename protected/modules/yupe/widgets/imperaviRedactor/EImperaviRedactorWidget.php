<?php

/*
    Файл класса EImperaviRedactorWidget.

    Пример использования:
    
        $this->widget( 'application.modules.yupe.widgets.imperaviRedactor.EImperaviRedactorWidget', 
            array(
                'model' => $model,
                'attribute' => $attribute,
                'options' => array(
                    'air'       => 'true',  // Включение режима AIR. По умолчанию false.
                    'focus'     => 'true',  // Устанавливает фокус на конкретный Редактор, особенно полезно, когда на странице несколько Редакторов. По умолчанию false.
                    'resize'    => 'true',  // Включение и отключение изменения высоты Редактора. По умолчанию false.
                    'toolbar'   => 'main'   // Указание, какой именно тулбар должен отобразиться в этом Редакторе. Возможные значения: false, main, mini. По умолчанию "main"
                ),
            )
        ) 
 
    Сайт редактора: http://imperavi.com/
    Документация по редактору: http://imperavi.com/redactor/docs/
*/

class EImperaviRedactorWidget extends CInputWidget {

    /* Путь до месторасположения активов (ресурсов) редактора. */
    public $assetsUrl;

    /* Путь до папки со скриптами */
    public $scriptFile;
    
    /* Путь до папки со стилями */
    public $cssFile;
    
    /*
        Массив передачи настроек редактору.
        Со списком возможных настроек можно ознакомится в документации редактора: http://imperavi.com/redactor/docs/.
    */
    public $options = array();

    /*
        Инициализация виджета
    */
    public function init() {

        list( $this->name, $this->id ) = $this->resolveNameId();

        if( $this->assetsUrl === null ) { 
            
            $this->assetsUrl = Yii::app()->getAssetManager()->publish( dirname(__FILE__) . '/assets', false, -1, YII_DEBUG );
            
        }

        if( $this->scriptFile === null ) {
            
            /*
                Выбераем файл скрипта редактора.
                --------------------------------
                Продуктивный режим: redactor.min.js (минимизированный)
                Дебаг режим: redactor.js
            */
            $this->scriptFile = $this->assetsUrl . '/' . ( YII_DEBUG ? 'redactor.js' : 'redactor.min.js' );
            
        }

        if( $this->cssFile === null ) {
            
            $this->cssFile = $this->assetsUrl . '/css/redactor.css';
            
        }

        $this->registerClientScript();
    
    }

    /*
        Вызов виджета
    */
    public function run() {
        
        if( $this->hasModel() ) {
            
            echo CHtml::activeTextArea( $this->model, $this->attribute, $this->htmlOptions );
            
        } else {
            
            echo CHtml::textArea( $this->name, $this->value, $this->htmlOptions );
            
        }
                    
    }
        
    /*
        Регистрация стилейи и сриптов
    */
    protected function registerClientScript() {

        if( isset( $this->options['path'] ) ) {

            $this->options['path'] = rtrim( $this->options['path'], '/\\' ) . '/';

        }

        $cs = Yii::app()->getClientScript();
        $cs->registerCssFile( $this->cssFile );
        $cs->registerCoreScript( 'jquery' );
        $cs->registerScriptFile( $this->scriptFile );
        $cs->registerScript( __CLASS__ . '#' . $this->id, 'jQuery("#' . $this->id . '").redactor(' . CJavaScript::encode( $this->options ) . ');' );
    }

}

?>