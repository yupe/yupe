<?php
/**
 * @var $this PostController
 */

$this->title = [Yii::t('BlogModule.blog', 'Posts of "{category}" category', ['{category}' => CHtml::encode($target->name)]), Yii::app()->getModule('yupe')->siteName];
$this->metaDescription = Yii::t('BlogModule.blog', 'Posts of "{category}" category', ['{category}' => CHtml::encode($target->name)]);
$this->metaKeywords = $target->name;
?>

<?php
$this->breadcrumbs = [
    Yii::t('BlogModule.blog', 'Posts')      => ['/blog/post/index/'],
    Yii::t('BlogModule.blog', 'Categories') => ['/blog/post/categories/'],
    CHtml::encode($target->name),
];
?>

<p><?php echo Yii::t(
        'BlogModule.blog',
        'Posts of "{category}" category',
        ['{category}' => CHtml::encode($target->name)]
    ); ?></p>

<?php $this->widget(
    'bootstrap.widgets.TbListView',
    [
        'dataProvider' => $posts->search(),
        'itemView'     => '_post',
        'template'     => "{items}\n{pager}",
    ]
); ?>
