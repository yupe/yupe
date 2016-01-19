<?php
/**
 * @var $this PostController
 * @var $target Blog
 */
$this->title = Yii::t('BlogModule.blog', 'Posts of "{blog}" blog', ['{blog}' => CHtml::encode($target->name)]);
$this->description = Yii::t('BlogModule.blog', 'Posts of "{blog}" blog', ['{blog}' => CHtml::encode($target->name)]);
$this->keywords = $target->name;
?>

<?php
$this->breadcrumbs = [
    Yii::t('BlogModule.blog', 'Blogs') => ['/blog/blog/index/'],
    CHtml::encode($target->name)       => ['/blog/blog/view/', 'slug' => CHtml::encode($target->slug)],
    Yii::t('BlogModule.blog', 'Records'),
];
?>
