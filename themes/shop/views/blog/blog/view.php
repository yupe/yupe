<?php
/**
 * @var $this BlogController
 * @var $blog Blog
 */
$this->title = [CHtml::encode($blog->name), Yii::app()->getModule('yupe')->siteName];
$this->metaDescription = CHtml::encode($blog->name);
$this->metaKeywords = CHtml::encode($blog->name);
?>

<?php
$this->breadcrumbs = [
    Yii::t('BlogModule.blog', 'Blogs') => ['/blog/blog/index/'],
    CHtml::encode($blog->name),
];
?>
