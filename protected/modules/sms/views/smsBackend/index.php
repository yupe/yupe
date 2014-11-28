<?php
/**
 * @author Zmiulan <info@yohanga.biz>
 * @link http://yohanga.biz
 * @copyright 2014 Zmiulan
 *
 */
$this->breadcrumbs=[
    Yii::t('SmsModule.sms', 'Sms')=>['index'],
    Yii::t('SmsModule.sms', 'Sms list'),
];
$this->pageTitle = Yii::t('SmsModule.sms', 'Sms list');

$this->menu=[
    ['icon'=> 'fa fa-fw fa-list', 'label' => Yii::t('SmsModule.sms', 'Sms list'),'url'=>['/sms/smsBackend/index']],
    ['icon'=> 'fa fa-fw fa-pencil', 'label' =>  Yii::t('SmsModule.sms', 'Sms send'),'url'=>['/sms/smsBackend/create']],
    ['icon'=> 'fa fa-fw fa-gears', 'label' =>  Yii::t('SmsModule.sms', 'Settings'),'url'=>['/backend/modulesettings?module=sms']],
];

Yii::app()->clientScript->registerScript(
    'search',
    "
    $('.search-button').click(function () {
    	$('.search-form').toggle();
    	return false;
    });
    $('.search-form').submit(function () {
    	$.fn.yiiGridView.update('sms-messages-grid', {
    		data: $(this).serialize()
    	});
    	return false;
    });"
);

?>
<div class="page-header">
    <h1><?php echo Yii::t('SmsModule.sms', 'Sms');?> <small><?php echo Yii::t('SmsModule.sms', 'Sms list');?></small>
    </h1>
</div>


<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo Yii::t('SmsModule.sms', 'Find sms messages'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
    $('.search-form').submit(function () {
        $.fn.yiiGridView.update('sms-messages-grid', {
            data: $(this).serialize()
        });

        return false;
    });"
    );

    $this->renderPartial('_search', ['model' => $model]);
    ?>
</div>

<?php
$this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id'             => 'sms-messages-grid',
        'dataProvider'   => $model->search(),
        'filter'         => $model,
        'actionsButtons' => [ ],
        'columns'        => [
            [
                'name'        => 'id',
                'type'        => 'raw',
                'value'       => 'CHtml::link($data->id, ["/sms/smsBackend/view", "id" => $data->id])',
                'htmlOptions' => ['style' => 'width:20px'],
            ],
            [
                'name'     => 'status',
                'type'    => 'raw',
                'filter'   => CHtml::activeTextField($model, 'status', ['class' => 'form-control']),
                'htmlOptions' => ['style' => 'width:20px'],
            ],
            [
                'name'     => 'to',
                'type'    => 'raw',
                'filter'   => CHtml::activeTextField($model, 'to', ['class' => 'form-control']),
            ],
            [
                'name'        => 'text',
                'type'       => 'raw',
                'htmlOptions' => [
                    'style' => 'width: 60%;'
                ],
                'filter'      => CHtml::activeTextField($model, 'text', ['class' => 'form-control']),
            ],
        ],
    ]
); ?>




