<?php
    $this->breadcrumbs = array(
        $this->getModule('vote')->getCategory() => array(),
        Yii::t('VoteModule.vote', 'Голосование') => array('/vote/default/index'),
        Yii::t('VoteModule.vote', 'Добавление'),
    );
    
    $this->menu = array(
        array('label' => Yii::t('VoteModule.vote', 'Управление голосами'), 'url' => array('/vote/default/index')),
        array('label' => Yii::t('VoteModule.vote', 'Добавить голос'), 'url' => array('/vote/default/create')),
    );
?>

<h1><?php echo Yii::t('VoteModule.vote', 'Добавление голоса'); ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>