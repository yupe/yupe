<?php
$this->title = Yii::t('NewsModule.news', 'News categories');
$this->breadcrumbs = [
    Yii::t('NewsModule.news', 'News') => ['/news/news/index'],
    Yii::t('NewsModule.news', 'News categories')
];
?>

<h1><?= Yii::t('NewsModule.news', 'News categories') ?></h1>
<ul>
    <?php foreach($categories as $category): ?>
        <li>
            <?= CHtml::link($category->name, ['/news/newsCategory/view', 'slug' => $category->slug]) ?>
        </li>
    <?php endforeach; ?>
</ul>