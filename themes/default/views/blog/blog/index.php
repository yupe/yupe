<?php
    $this->pageTitle = Yii::t('BlogModule.blog', 'Блоги');
    $this->breadcrumbs = array(Yii::t('BlogModule.blog', 'Блоги'));
?>

<h1><small><?php echo Yii::t('BlogModule.blog', 'Блоги'); ?> <a href="<?php echo Yii::app()->createUrl('/blog/blogRss/feed/');?>"><img src="<?php echo Yii::app()->AssetManager->publish(Yii::app()->theme->basePath . "/web/images/rss.png"); ?>" alt="<?php echo Yii::t('BlogModule.blog', 'Subscribe for updates') ?>" title="<?php echo Yii::t('BlogModule.blog', 'Subscribe for updates') ?>"></a></small></h1>

<?php
$this->widget(
    'bootstrap.widgets.TbListView', array(
        'dataProvider' => $dataProvider,
        'template' => '{items} {pager}',
        'itemView' => '_view',
    )
); ?>