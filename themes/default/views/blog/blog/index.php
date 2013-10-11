<?php
    $this->pageTitle = Yii::t('blog', 'Блоги');
    $this->breadcrumbs = array(Yii::t('blog', 'Блоги'));
?>

<h1><small>Блоги <a href="<?php echo Yii::app()->createUrl('/blog/rss/feed/');?>"><img src="<?php echo Yii::app()->AssetManager->publish(Yii::app()->theme->basePath . "/web/images/rss.png"); ?>" alt="Подпишитесь на обновления" title="Подпишитесь на обновления"></a></small></h1>

<?php
$this->widget(
    'bootstrap.widgets.TbListView', array(
        'dataProvider' => $dataProvider,
        'template' => '{items} {pager}',
        'itemView' => '_view',
    )
); ?>