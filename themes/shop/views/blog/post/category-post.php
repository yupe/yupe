<?php
/**
 * @var $this PostController
 */

$this->title = Yii::t('BlogModule.blog', 'Posts of "{category}" category', ['{category}' => CHtml::encode($target->name)]);
$this->description = Yii::t('BlogModule.blog', 'Posts of "{category}" category', ['{category}' => CHtml::encode($target->name)]);
$this->keywords = $target->name;
?>

<?php
$this->breadcrumbs = [
    Yii::t('BlogModule.blog', 'Posts')      => ['/blog/post/index/'],
    Yii::t('BlogModule.blog', 'Categories') => ['/blog/post/categories/'],
    CHtml::encode($target->name),
];
?>
