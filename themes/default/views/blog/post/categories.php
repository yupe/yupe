<?php $this->title = [Yii::t('BlogModule.blog', 'Categories'), Yii::app()->getModule('yupe')->siteName]; ?>

<?php
$this->breadcrumbs = [
    Yii::t('BlogModule.blog', 'Posts') => ['/blog/post/index/'],
    Yii::t('BlogModule.blog', 'Categories')
];
?>

<?php foreach ($categories as $category): ?>

<h4><strong><?php echo CHtml::link(
            CHtml::encode($category['name']),
            ['/blog/post/category/', 'alias' => CHtml::encode($category['alias'])]
        ); ?></strong>
    <?php echo strip_tags($category['description']); ?>
    <hr/>

    <?php endforeach; ?>
