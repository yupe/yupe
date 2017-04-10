<?php
$this->breadcrumbs = array(
    Yii::t('MetrikaModule.metrika', 'Metrika') => array('/metrika/metrikaBackend/index'),
    Yii::t('MetrikaModule.metrika', 'Show url').' «'.mb_substr($model->id, 0).'»',
);

$this->pageTitle = Yii::t('MetrikaModule.metrika', 'News - show');

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('MetrikaModule.metrika', 'List of links'), 'url' => array('/metrika/metrikaBackend/index')),
    array('icon' => 'list-alt', 'label' => Yii::t('MetrikaModule.metrika', 'List of transitions'), 'url' => array('/metrika/metrikaBackend/transitions')),

    array('label' => Yii::t('MetrikaModule.metrika', 'Show url').' «'.mb_substr($model->id, 0).'»'),
    array('icon' => 'eye-open', 'label' => Yii::t('MetrikaModule.metrika', 'Show url'), 'url' => array(
        '/metrika/metrikaBackend/view',
        'id' => $model->id
    )),
);
?>

<div class="page-header">
     <h1>
         <?php echo Yii::t('MetrikaModule.metrika', 'Show url'); ?><br />
        <small>&laquo;<?php echo $model->url; ?>&raquo;</small>
     </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    array(
        'data'       => $model,
        'attributes' => array(
            'id',
            'url',
            'views',
        ),
    )
); ?>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    array(
        'id'           => 'metrika-block-grid',
        'dataProvider' => $transitions->search(),
        'filter'       => $transitions,
        'columns'      => array(
            array(
                'name'  => 'id',
                'type'  => 'raw',
                'value' => '$data->id',
                'htmlOptions' => array('style' => 'width:50px'),
            ),
            array(
                'name'  => 'url_id',
                'type'  => 'raw',
                'value' => '$data->url->url',
            ),
            array(
                'name'  => 'date',
                'type'  => 'raw',
                'value' => '$data->date',
                'htmlOptions' => array('style' => 'width:150px'),
            ),
            'params_get',
        ),
    )
); ?>
