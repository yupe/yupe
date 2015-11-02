<?php $this->title = [Yii::t('BlogModule.blog', 'Categories'), Yii::app()->getModule('yupe')->siteName]; ?>

<?php
$this->breadcrumbs = [
    Yii::t('BlogModule.blog', 'Posts') => ['/blog/post/index/'],
    Yii::t('BlogModule.blog', 'Categories')
];
?>

<?php foreach ($categories as $category): ?>

<h4><strong><?= CHtml::link(
            CHtml::encode($category['name']),
            ['/blog/post/category/', 'slug' => CHtml::encode($category['slug'])]
        ); ?></strong>
    <?= strip_tags($category['description']); ?>
    <hr/>

    <?php endforeach; ?>
