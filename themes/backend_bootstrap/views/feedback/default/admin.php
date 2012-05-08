<?php $this->pageTitle = Yii::t('feedback', 'Сообщения с сайта'); ?>

<?php
//@formatter:off
$this->breadcrumbs = array(
    Yii::t('feedback', 'Сообщения с сайта') => array('admin'),
    Yii::t('feedback', 'Управление'),
);

$this->menu = array(
    array('label' => Yii::t('feedback', 'Управление сообщениями'), 'url' => array('/feedback/default/admin')),
    array('label' => Yii::t('feedback', 'Добавить сообщение'), 'url' => array('/feedback/default/create')),

);
//@formatter:on
Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function() {
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('feed-back-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
?>
<div class="page-header"><h1><?=$this->module->getName()?> <small><?php echo Yii::t('feedback', 'Управление');?></small></h1></div>

<?php echo CHtml::link(Yii::t('feedback', 'Поиск сообщений'), '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array('model' => $model)); ?>
</div><!-- search-form -->

<?php
        $dp = $model->search();
        $dp->criteria->order = 'status ASC, change_date ASC';
        $this->widget('YCustomGridView', array(
        'statusField' => 'is_faq',
        'id' => 'feed-back-grid',
        'dataProvider' => $dp,
        'itemsCssClass' => ' table table-condensed',
        'columns' => array(
            array(
                'name' => 'id',
                'header' => '№',
            ),
            array(
                'name' => 'is_faq',
                'type' => 'raw',
                'header' => 'FAQ',
                'value' => '$this->grid->returnStatusHtml($data)',
            ),
            array(
                'name' => 'status',
                'type' => 'raw',
                'value' => "'<span class=\"label label-'.(\$data->status?((\$data->status==1)?'warning':((\$data->status==3)?'success':'default')):'info').'\">'.\$data-> getStatus().'</span>'",
                'filter' => CHtml::activeDropDownList($model, 'status', $model->getTypeList()),
            ),
            array(
                'name' => 'change_date',
                'value' => "(\$data->change_date!='0000-00-00 00:00:00')?Yii::app()->dateFormatter->formatDateTime(\$data-> change_date,'short'):'—'",
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
            /*
                        'name',
                        'email',
                        array(
                            'name' => 'creation_date',
                            'value' => "Yii::app()->dateFormatter->formatDateTime(\$data-> creation_date,'short')",
                        ),
            */
            array('class' => 'bootstrap.widgets.BootButtonColumn'),
        ),
    ));
 ?>
