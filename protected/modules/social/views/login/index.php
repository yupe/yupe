<?php
    $this->breadcrumbs = array(
        $this->getModule('social')->getCategory() => array(),
        Yii::t('social', 'Социализация') => array('/social/default/index'),
        Yii::t('social', 'Авторизационные данные') => array('/social/default/index'),
        Yii::t('social', 'Управление'),
    );

    $this->menu = array(
        array('label' => Yii::t('social', 'Управление'), 'url' => array('/social/default/index')),
        array('label' => Yii::t('social', 'Просмотреть'), 'url' => array('/social/default/view', 'id' => $model->id)),
    );
?>

<h1><?php echo Yii::t('social', 'Авторизационные данные'); ?></h1>

<?php echo CHtml::link(Yii::t('social', 'Поиск'), '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array('model' => $model)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'           => 'login-grid',
    'dataProvider' => $model->search(),
    'columns'      => array(
        'id',
        array(
            'name'  => 'user_id',
            'value' => '$data->user->getFullName()." ({$data->user->nick_name})"'
        ),
        'identity_id',
        'type',
        'creation_date',
        array(
            'class' => 'CButtonColumn',
        ),
    ),
)); ?>