<?php
	$feedback = Yii::app()->getModule('feedback');
	$this->breadcrumbs = array(
		$feedback->getCategory() => array('/yupe/backend/index', 'category' => $feedback->getCategoryType() ),
        Yii::t('FeedbackModule.feedback', 'Сообщения с сайта'),
    );

    $this->pageTitle = Yii::t('FeedbackModule.feedback', 'Сообщения с сайта - управление');

    $this->menu = array(
    	array('label' => Yii::t('FeedbackModule.feedback', 'Сообщения с сайта'), 'items' => array(
			array('icon' => 'list-alt', 'label' => Yii::t('FeedbackModule.feedback', 'Управление сообщениями с сайта'), 'url' => array('/feedback/defaultAdmin/index')),
        	array('icon' => 'plus-sign', 'label' => Yii::t('FeedbackModule.feedback', 'Добавить сообщение с сайта'), 'url' => array('/feedback/defaultAdmin/create')),
    	)),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('FeedbackModule.feedback', 'Сообщения с сайта'); ?>
        <small><?php echo Yii::t('FeedbackModule.feedback', 'управление'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('FeedbackModule.feedback', 'Поиск сообщений с сайта'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('feed-back-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->renderPartial('_search', array('model' => $model));
?>
</div>

<br/>

<p><?php echo Yii::t('FeedbackModule.feedback', 'В данном разделе представлены средства управления сообщениями с сайта'); ?></p>

<?php $this->widget('application.modules.yupe.components.YCustomGridView', array(
    'id'           => 'feed-back-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        array(
            'name'   => 'id',
            'header' => '№',
        ),
        array(
            'name'  => 'theme',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->theme, array("/feedback/defaultAdmin/update", "id" => $data->id))',
        ),
        array(
            'name'  => 'type',
            'value' => '$data->getType()',
            'filter' => CHtml::activeDropDownList($model, 'type', $model->typeList),
        ),
        array(
            'name'  => 'category_id',
            'value' => '$data->getCategory()',
            'filter' => CHtml::activeDropDownList($model, 'category_id', CHtml::listData($this->module->getCategoryList(),'id','name')),
        ),
        'email',
        'phone',
        array(
            'name'  => 'creation_date',
            'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->creation_date, "short", "short")',
        ),
        array(
            'name'   => 'status',
            'type'   => 'raw',
            'value'  => "'<span class=\"label label-' . (\$data->status ? ((\$data->status == 1) ? 'warning' : ((\$data->status==3)?  'success' : 'default')) : 'info').'\">' . \$data->getStatus() . '</span>'",
            'filter' => CHtml::activeDropDownList($model, 'status', $model->statusList),
        ),
        array(
            'name'   => 'is_faq',
            'type'   => 'raw',
            'header' => 'FAQ',
            'value'  => '$this->grid->returnBootstrapStatusHtml($data, "is_faq", "IsFaq")',
        ),
        array('class' => 'bootstrap.widgets.TbButtonColumn'),
    ),
)); ?>