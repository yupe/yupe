<?php
    $this->breadcrumbs = array(
        $this->getModule('vote')->getCategory() => array(),
        Yii::t('VoteModule.vote', 'Голосование') => array('/vote/default/index'),
        Yii::t('VoteModule.vote', 'Управление'),
    );

    $this->menu = array(
        array('label' => Yii::t('VoteModule.vote', 'Управление голосами'), 'url' => array('/vote/default/index')),
        array('label' => Yii::t('VoteModule.vote', 'Добавить голос'), 'url' => array('/vote/default/create')),
    );
?>

<h1><?php echo $this->module->getName();?></h1>

<?php $this->widget('YModuleInfo'); ?>

<?php echo CHtml::link(Yii::t('VoteModule.vote', 'Поиск'), '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array('model' => $model)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'           => 'vote-grid',
    'dataProvider' => $model->search(),
    'columns'      => array(
        'id',
        'model',
        'model_id',
        array(
            'name'  => 'user_id',
            'value' => '$data->user->nick_name . " (" . $data->user_id . ")"'
        ),
        'creation_date',
        'value',
        array(
             'class' => 'CButtonColumn',
        ),
    ),
)); ?>