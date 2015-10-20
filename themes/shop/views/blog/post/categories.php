<?php $this->title = [Yii::t('BlogModule.blog', 'Categories'), Yii::app()->getModule('yupe')->siteName]; ?>

<?php
$this->breadcrumbs = [
    Yii::t('BlogModule.blog', 'Posts') => ['/blog/post/index/'],
    Yii::t('BlogModule.blog', 'Categories')
];
?>
