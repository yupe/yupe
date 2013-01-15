<?php
    $comment = Yii::app()->getModule('blog');
    $this->breadcrumbs = array(
        $comment->getCategory() => array('/yupe/backend/index', 'category' => $comment->getCategoryType() ),
        Yii::t('CommentModule.comment', 'Комментарии') => array('/comment/defaultAdmin/index'),
        Yii::t('CommentModule.comment', 'Добавление'),
    );

    $this->pageTitle = Yii::t('category', 'Комментарий - добавление');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('CommentModule.comment', 'Список комментариев'), 'url' => array('/comment/defaultAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('CommentModule.comment', 'Добавить комментарий'), 'url' => array('/comment/defaultAdmin/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CommentModule.comment', 'Комментарии'); ?>
        <small><?php echo Yii::t('CommentModule.comment', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>