<?php $this->pageTitle = Yii::t('feedback', 'Сообщения с сайта'); ?>

<?php
$this->breadcrumbs = array(
    $this->module->getCategory() => array('admin'),
    Yii::t('feedback', 'Сообщения с сайта') => array('admin'),
    Yii::t('feedback', 'Управление'),
);

$this->menu = array(
    array('icon' => 'list-alt white', 'label' => Yii::t('feedback', 'Управление сообщениями'), 'url' => array('/feedback/default/admin')),
    array('icon' => 'plus-sign', 'label' => Yii::t('feedback', 'Добавить сообщение'), 'url' => array('/feedback/default/create')),

);
Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function() {
        $('.search-form').toggle();
        return false;
    });
    $('.search-form').submit(function() {
        $.fn.yiiGridView.update('feed-back-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
?>
<div class="page-header"><h1><?php echo $this->module->getName(); ?> <small><?php echo Yii::t('feedback', 'управление'); ?></small></h1></div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('feedback', 'Поиск сообщений'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out">
 <?php
  
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div>

<br/>

<p><?php echo Yii::t('feedback', 'В данном разделе представлены средства управления сообщениями с сайта'); ?></p>


<?php
    $this->widget('YCustomGridView', array(
        'id' => 'feed-back-grid',
        'dataProvider' => $model->search(),
        'itemsCssClass' => ' table table-condensed',
        'columns' => array(
            array(
                'name' => 'id',
                'header' => '№',
            ),
            array(
                'name' => 'theme',
                'type' => 'raw',
                'value' => 'CHtml::link($data->theme, array("/feedback/default/update/", "id" => $data->id))',
            ),
            array(
                'name' => 'type',
                'value' => '$data->getType()',
            ),
            'email',
            'phone',
            array(
                'name' => 'creation_date',
                'value' => "Yii::app()->dateFormatter->formatDateTime(\$data->creation_date, 'short')",
            ),
            array(
                'name' => 'status',
                'type' => 'raw',
                'value' => "'<span class=\"label label-' . (\$data->status ? ((\$data->status == 1) ? 'warning' : ((\$data->status==3)?  'success' : 'default')) : 'info').'\">' . \$data->getStatus() . '</span>'",
                'filter' => CHtml::activeDropDownList($model, 'status', $model->typeList),
            ),
            array(
                'name' => 'is_faq',
                'type' => 'raw',
                'header' => 'FAQ',
                'value' => '$this->grid->returnBootstrapStatusHtml($data, "is_faq", "IsFaq")',
            ),
            array('class' => 'bootstrap.widgets.TbButtonColumn'),
        ),
    ));
 ?>
