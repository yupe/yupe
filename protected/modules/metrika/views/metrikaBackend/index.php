<?php
$this->breadcrumbs = array(
    Yii::t('MetrikaModule.metrika', 'Metrika') => array('/metrika/metrikaBackend/index'),
    Yii::t('MetrikaModule.metrika', 'Metrika'),
);

$this->pageTitle = Yii::t('MetrikaModule.metrika', 'Metrika');

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('MetrikaModule.metrika', 'List of links'), 'url' => array('/metrika/metrikaBackend/index')),
    array('icon' => 'list-alt', 'label' => Yii::t('MetrikaModule.metrika', 'List of transitions'), 'url' => array('/metrika/metrikaBackend/transitions')),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t('MetrikaModule.metrika', 'Metrika'); ?></h1>
</div>

<br/>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    array(
        'id'           => 'metrika-block-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => array(
            array(
                'name'  => 'id',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->id, array("/metrika/metrikaBackend/view", "id" => $data->id))',
                'htmlOptions' => array('style' => 'width:50px'),
            ),
            'url',
            array(
                'name'  => 'views',
                'type'  => 'raw',
                'value' => '$data->views',
                'htmlOptions' => array('style' => 'width:200px'),
            ),
        ),
    )
);
?>