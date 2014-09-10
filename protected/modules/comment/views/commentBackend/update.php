<?php
$this->breadcrumbs = array(
    Yii::t('CommentModule.comment', 'Comments') => array('/comment/commentBackend/index'),
    $model->id                                  => array('/comment/commentBackend/view', 'id' => $model->id),
    Yii::t('CommentModule.comment', 'Edit'),
);

$this->pageTitle = Yii::t('CommentModule.comment', 'Comments - edit');

$this->menu = array(
    array(
        'icon'  => 'glyphicon glyphicon-list-alt',
        'label' => Yii::t('CommentModule.comment', 'Manage comments'),
        'url'   => array('/comment/commentBackend/index')
    ),
    array(
        'icon'  => 'glyphicon glyphicon-plus-sign',
        'label' => Yii::t('CommentModule.comment', 'Create comment'),
        'url'   => array('/comment/commentBackend/create')
    ),
    array('label' => Yii::t('CommentModule.comment', 'Comment') . ' «' . mb_substr($model->id, 0, 32) . '»'),
    array(
        'icon'  => 'glyphicon glyphicon-pencil',
        'label' => Yii::t('CommentModule.comment', 'Edit comment'),
        'url'   => array(
            '/comment/commentBackend/update',
            'id' => $model->id
        )
    ),
    array(
        'icon'  => 'glyphicon glyphicon-eye-open',
        'label' => Yii::t('CommentModule.comment', 'View comment'),
        'url'   => array(
            '/comment/commentBackend/view',
            'id' => $model->id
        )
    ),
    array(
        'icon'        => 'glyphicon glyphicon-trash',
        'label'       => Yii::t('CommentModule.comment', 'Delete comment'),
        'url'         => '#',
        'linkOptions' => array(
            'submit'  => array('/comment/commentBackend/delete', 'id' => $model->id),
            'params'  => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t('CommentModule.comment', 'Do you really want do remove comment?'),
        )
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CommentModule.comment', 'Edit comment'); ?><br/>
        <small>&laquo;<?php echo $model->id; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
