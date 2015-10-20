<?php
/**
 * @var $this PostController
 */
$this->title = [Yii::t('BlogModule.blog', 'Latest posts'), Yii::app()->getModule('yupe')->siteName];
$this->metaDescription = Yii::t('BlogModule.blog', 'Latest post');
$this->metaKeywords = Yii::t('BlogModule.blog', 'Latest post');
?>

<?php $this->breadcrumbs = [
    Yii::t('BlogModule.blog', 'Blogs') => ['/blog/blog/index/'],
    Yii::t('BlogModule.blog', 'Latest posts'),
]; ?>
