<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('comment')->getCategory() => array(),
        Yii::t('CommentModule.comment', 'Comments.') => array('/comment/default/index'),
        Yii::t('CommentModule.comment', 'Create'),
    );

    $this->pageTitle = Yii::t('CommentModule.comment', 'Comment - create');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('CommentModule.comment', 'Comments list'), 'url' => array('/comment/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('CommentModule.comment', 'Create comment'), 'url' => array('/comment/default/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CommentModule.comment', 'Comments.'); ?>
        <small><?php echo Yii::t('CommentModule.comment', 'create'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>