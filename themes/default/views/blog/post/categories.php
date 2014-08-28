<?php $this->pageTitle = Yii::t('BlogModule.blog', 'Categories'); ?>

<?php
$this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Posts') => array('/blog/post/index/'),
    Yii::t('BlogModule.blog', 'Categorys')
);
?>

<?php foreach ($categories as $category): ?>

<h4><strong><?php echo CHtml::link(
            CHtml::encode($category['name']),
            array('/blog/post/category/', 'alias' => CHtml::encode($category['alias']))
        ); ?></strong>
    <?php echo strip_tags($category['description']); ?>
    <hr/>

    <?php endforeach; ?>
