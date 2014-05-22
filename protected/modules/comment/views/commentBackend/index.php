<?php
    $this->breadcrumbs = array(       
        Yii::t('CommentModule.comment', 'Comments') => array('/comment/commentBackend/index'),
        Yii::t('CommentModule.comment', 'Manage'),
    );

    $this->pageTitle = Yii::t('CommentModule.comment', 'Comments - management');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('CommentModule.comment', 'Comments list'), 'url' => array('/comment/commentBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('CommentModule.comment', 'Create comment'), 'url' => array('/comment/commentBackend/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CommentModule.comment', 'Comments'); ?>
        <small><?php echo Yii::t('CommentModule.comment', 'manage'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('CommentModule.comment', 'Find comments'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('comment-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->renderPartial('_search', array('model' => $model));
?>
</div>

<br/>

<p><?php echo Yii::t('CommentModule.comment', 'This section describes comment management'); ?></p>

<?php $this->widget('yupe\widgets\CustomGridView', array(
    'id'           => 'comment-grid',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns' => array(
        array(
            'name' => 'id',
            'htmlOptions' => array('style' => 'width:20px'),
            'value' => 'CHtml::link($data->id, array("/comment/commentBackend/update", "id" => $data->id))',
            'type'  => 'raw'
        ),
        array(
            'name'   => 'model',
            'value'  => '$data->getTargetTitleLink()',
            'type'   => 'html'
        ),
        'model_id',
        array(
            'class'  => 'bootstrap.widgets.TbEditableColumn',
            'editable' => array(
                'url'  => $this->createUrl('/comment/commentBackend/inline'),
                'mode' => 'popup',
                'type' => 'select',
                'source' => $model->getStatusList(),
                'params' => array(
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                )
            ),
            'name'   => 'status',
            'type'   => 'raw',
            'value'  => '$data->getStatus()',
            'filter' => $model->getStatusList()
        ),
        array(
            'name'  => 'text',
            'value' => 'yupe\helpers\YText::characterLimiter($data->text, 150)',
            'type'  => 'html'
        ),
        array(
            'name'  => 'creation_date',
            'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->creation_date, "short", "short")',
        ),
        'name',
        'email',
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>