<?php
    $this->breadcrumbs = array(
        $this->module->getCategory() => array('/yupe/backend/index', 'category' => $this->module->getCategoryType()),
        Yii::t('VoteModule.vote', 'Голосование') => array('/vote/defaultAdmin/index'),
        Yii::t('VoteModule.vote', 'Добавление'),
    );
    
    $this->menu = array(
        array('label' => Yii::t('VoteModule.vote', 'Голосование'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('VoteModule.vote', 'Управление голосами'), 'url' => array('/vote/defaultAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('VoteModule.vote', 'Добавить голос'), 'url' => array('/vote/defaultAdmin/create')),
        ))
    );
?>

<h1><?php echo Yii::t('VoteModule.vote', 'Добавление голоса'); ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>