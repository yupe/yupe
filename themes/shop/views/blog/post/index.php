<?php
/**
 * @var $this PostController
 */
$this->title = Yii::t('BlogModule.blog', 'Latest posts');
$this->description = Yii::t('BlogModule.blog', 'Latest post');
$this->keywords = Yii::t('BlogModule.blog', 'Latest post');
?>

<?php $this->breadcrumbs = [
    Yii::t('BlogModule.blog', 'Blogs') => ['/blog/blog/index/'],
    Yii::t('BlogModule.blog', 'Latest posts'),
]; ?>
