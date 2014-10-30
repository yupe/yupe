<?php
$this->breadcrumbs = array(
    Yii::t('CommentModule.comment', 'Comments') => array('/comment/commentBackend/index'),
    Yii::t('CommentModule.comment', 'Manage'),
);

$this->pageTitle = Yii::t('CommentModule.comment', 'Comments - management');

$this->menu = array(
    array(
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('CommentModule.comment', 'Comments list'),
        'url'   => array('/comment/commentBackend/index')
    ),
    array(
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('CommentModule.comment', 'Create comment'),
        'url'   => array('/comment/commentBackend/create')
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CommentModule.comment', 'Comments'); ?>
        <small><?php echo Yii::t('CommentModule.comment', 'manage'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo Yii::t('CommentModule.comment', 'Find comments'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out search-form">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
    $('.search-form form').submit(function () {
        $.fn.yiiGridView.update('comment-grid', {
            data: $(this).serialize()
        });

        return false;
    });
"
    );
    $this->renderPartial('_search', array('model' => $model));
    ?>
</div>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    array(
        'id'           => 'comment-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => array(
            array(
                'name'  => 'model',
                'value' => '$data->getTargetTitleLink()',
                'type'  => 'html'
            ),
            'model_id',
            array(
                'name'  => 'text',
                'value' => 'yupe\helpers\YText::characterLimiter($data->text, 150)',
                'type'  => 'html'
            ),
            array(
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'status',
                'url'     => $this->createUrl('/comment/commentBackend/inline'),
                'source'  => $model->getStatusList(),
                'options' => [
                    Comment::STATUS_APPROVED   => ['class' => 'label-success'],
                    Comment::STATUS_DELETED    => ['class' => 'label-default'],
                    Comment::STATUS_NEED_CHECK => ['class' => 'label-warning'],
                    Comment::STATUS_SPAM       => ['class' => 'label-danger'],
                ],
            ),
            array(
                'name'  => 'creation_date',
                'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->creation_date, "short", "short")',
            ),
            'name',
            'email',
            array(
                'class' => 'yupe\widgets\CustomButtonColumn',
            ),
        ),
    )
); ?>
