<?php
    Yii::app()->setComponent('bootstrap', Yii::createComponent(array(
        'class'=>$themeBase.'.extensions.bootstrap.components.Bootstrap',
    )));
    
    Yii::setPathOfAlias('bootstrap', Yii::app()->theme->basePath.'/extensions/bootstrap');
    Yii::app()->preload[] = 'bootstrap';
?>