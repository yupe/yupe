<?php
    $this->breadcrumbs = array(
        $this->module->getCategory() => array('/yupe/backend/index', 'category' => $this->module->getCategoryType()),
        Yii::t('VoteModule.vote', 'Голосование') => array('/vote/defaultAdmin/index'),
        $model->id => array('/vote/defaultAdmin/view', 'id' => $model->id),
        Yii::t('VoteModule.vote', 'Редактирование'),
    );

     $this->menu = array(
        array('label' => Yii::t('VoteModule.vote', 'Голосование'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('VoteModule.vote', 'Управление голосами'), 'url' => array('/vote/defaultAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('VoteModule.vote', 'Добавить голос'), 'url' => array('/vote/defaultAdmin/create')),
        )),
        array('label' => Yii::t('VoteModule.vote', 'Голосование'). ' «' . mb_substr($model->id, 0, 32) . '»', 'items' => array(
            array('icon' => 'pencil', 'label' => Yii::t('VoteModule.vote', 'Редактировать голос'), 'url' => array(
                '/vote/defaultAdmin/update',
                'id' => $model->id
            )),
            array('icon' => 'eye-open', 'label' => Yii::t('VoteModule.vote', 'Просмотреть голос'), 'url' => array(
                '/vote/defaultAdmin/view', 
                'id' => $model->id
            )),
            
            array('icon' => 'trash', 'label' => Yii::t('VoteModule.vote', 'Удалить голос'), 'url' => '#', 'linkOptions' => array(
                'submit'  => array('/vote/defaultAdmin/delete', 'id' => $model->id),
                'confirm' => 'Подтверждаете удаление ?',
            )),
        ))
    );
?>

<h1><?php echo Yii::t('VoteModule.vote', 'Редактирование голоса');?>
    № <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>