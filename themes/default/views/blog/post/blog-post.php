<?php $this->pageTitle = $target->name; ?>
<?php
$this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Blogs') => array('/blog/blog/index/'),
    CHtml::encode($target->name) => array('/blog/blog/show/', 'slug' => $target->slug),
    Yii::t('BlogModule.blog', 'Records'),
);
?>

<?php $this->widget('bootstrap.widgets.TbListView', array(
        'dataProvider' => $posts->search(),
        'itemView'     => '_view',
        'template'     => "{items}\n{pager}",
    )); ?>