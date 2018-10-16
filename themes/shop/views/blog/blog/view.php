<?php
/**
 * @var $this BlogController
 * @var $blog Blog
 */
$this->title = CHtml::encode($blog->name);
$this->description = CHtml::encode($blog->name);
$this->keywords = CHtml::encode($blog->name);
?>

<?php
$this->breadcrumbs = [
    Yii::t('BlogModule.blog', 'Blogs') => ['/blog/blog/index/'],
    CHtml::encode($blog->name),
];
?>
