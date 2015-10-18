<?php
/**
 * @var $this PostController
 */

$this->title = [Yii::t('BlogModule.blog', 'Posts list with tag "{tag}"', ['{tag}' => CHtml::encode($tag)]), Yii::app()->getModule('yupe')->siteName]; ?>

<?php $this->breadcrumbs = [
    Yii::t('BlogModule.blog', 'Blogs') => ['/blog/blog/index/'],
    Yii::t('BlogModule.blog', 'Posts list'),
]; ?>
