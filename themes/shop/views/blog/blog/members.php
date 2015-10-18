<?php
/**
 * @var $this BlogController
 * @var $form TbActiveForm
 * @var $blog Blog
 */

$this->title = Yii::t('UserModule.user', 'Users');
$this->metaDescription = Yii::t('BlogModule.blog', 'Members of "{blog}" blog', ['{blog}' => CHtml::encode($blog->name)]);
$this->metaKeywords = Yii::t('BlogModule.blog', 'Members');
$this->breadcrumbs = [
    Yii::t('BlogModule.blog', 'Blogs') => ['/blog/blog/index'],
    CHtml::encode($blog->name)         => ['/blog/blog/view', 'slug' => CHtml::encode($blog->slug)],
    Yii::t('UserModule.user', 'Users'),
];
?>
