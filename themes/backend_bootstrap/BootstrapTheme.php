<?php
    Yii::app()->setComponents(array(
        'bootstrap' => array(
            'class' => $themeBase.'.extensions.bootstrap.components.Bootstrap',
        )
    ));

    Yii::setPathOfAlias('bootstrap',Yii::app()->theme->basePath.'/extensions/bootstrap');
    Yii::app()->preload[]='bootstrap';
?>