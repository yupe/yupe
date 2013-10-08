<?php $this->pageTitle = Yii::t('default', 'Блоги'); ?>
<?php $this->breadcrumbs = array(Yii::t('default', 'Блоги')); ?>

<h1>
    <small><?php echo Yii::t('default','Блоги');?> <a href="<?php echo Yii::app()->createUrl('/blog/rss/feed/');?>">
    <img src="<?php echo Yii::app()->assetManager->publish(Yii::app()->theme->basePath . '/web');?>/images/rss.png" alt="<?php echo Yii::t('default','Подпишитесь на обновления');?>" title="<?php echo Yii::t('default','Подпишитесь на обновления');?>"></a></small>
</h1>

<?php
$this->widget(
    'bootstrap.widgets.TbListView', array(
        'dataProvider' => $dataProvider,
        'itemView' => '_view',
        'template' => '{items}'
    )
); ?>