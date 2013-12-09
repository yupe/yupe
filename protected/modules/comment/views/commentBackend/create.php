<?php
    $this->breadcrumbs = array(       
        Yii::t('CommentModule.comment', 'Comments') => array('/comment/commentBackend/index'),
        Yii::t('CommentModule.comment', 'Create'),
    );

    $this->pageTitle = Yii::t('CommentModule.comment', 'Comment - create');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('CommentModule.comment', 'Comments list'), 'url' => array('/comment/commentBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('CommentModule.comment', 'Create comment'), 'url' => array('/comment/commentBackend/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CommentModule.comment', 'Comments'); ?>
        <small><?php echo Yii::t('CommentModule.comment', 'create'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>