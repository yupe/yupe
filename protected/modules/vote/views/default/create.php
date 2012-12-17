<?php
    $this->breadcrumbs = array(
        $this->getModule('vote')->getCategory() => array(),
        Yii::t('vote', 'Голосование') => array('/vote/default/index'),
        Yii::t('vote', 'Добавление'),
    );
    
    $this->menu = array(
        array('label' => Yii::t('vote', 'Управление голосами'), 'url' => array('/vote/default/index')),
        array('label' => Yii::t('vote', 'Добавить голос'), 'url' => array('/vote/default/create')),
    );
?>

<h1><?php echo Yii::t('vote', 'Добавление голоса'); ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>