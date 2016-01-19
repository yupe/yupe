<?php
/**
 * @var $this PostController
 */

$this->title = Yii::t('BlogModule.blog', 'Posts list with tag "{tag}"', ['{tag}' => CHtml::encode($tag)]); ?>

<?php $this->breadcrumbs = [
    Yii::t('BlogModule.blog', 'Blogs') => ['/blog/blog/index/'],
    Yii::t('BlogModule.blog', 'Posts list'),
]; ?>
