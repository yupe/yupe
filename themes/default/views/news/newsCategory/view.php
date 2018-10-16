<?php
/**
 * @var Category $category
 */

$this->title = $category->name;
$this->breadcrumbs = [
    Yii::t('NewsModule.news', 'News') => ['/news/news/index'],
    Yii::t('NewsModule.news', 'News categories') => ['/news/newsCategory/index'],
    $category->name,
];
?>

<h1><?= Yii::t('NewsModule.news', 'News in category {name}', ['{name}' => $category->name]) ?></h1>

<?php $this->widget(
    'bootstrap.widgets.TbListView',
    [
        'dataProvider' => $dataProvider,
        'itemView' => '//news/news/_item',
    ]
); ?>
