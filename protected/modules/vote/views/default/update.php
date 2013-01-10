<?php
    $this->breadcrumbs = array(
        $this->getModule('vote')->getCategory() => array(),
        Yii::t('VoteModule.vote', 'Голосование') => array('/vote/default/index'),
        Yii::t('VoteModule.vote', 'Редактирование'),
    );

    $this->menu = array(
        array('label' => Yii::t('VoteModule.vote', 'Управление голосами'), 'url' => array('/vote/default/index')),
        array('label' => Yii::t('VoteModule.vote', 'Добавить голос'), 'url' => array('/vote/default/create')),
        array('label' => Yii::t('VoteModule.vote', 'Просмотреть голос'), 'url' => array('/vote/default/view', 'id' => $model->id)),
        array('label' => Yii::t('VoteModule.vote', 'Редактировать голос'), 'url' => array('/vote/default/update', 'id' => $model->id)),
        array('label' => Yii::t('VoteModule.vote', 'Удалить голос'), 'url' => '#', 'linkOptions' => array(
            'submit'  => array('/vote/default/delete', 'id' => $model->id),
            'confirm' => 'Подтверждаете удаление ?',
        )),
    );
?>

<h1><?php echo Yii::t('VoteModule.vote', 'Редактирование голоса');?>
    № <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>