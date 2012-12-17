<?php $this->pageTitle = Yii::t('gallery', 'Галереи изображений!'); ?>

<h1><?php echo Yii::t('gallery', 'Галереи изображений!');?></h1>

<?php $this->widget('zii.widgets.CListView', array(
                                                  'dataProvider' => $dataProvider,
                                                  'itemView' => '_view',
                                             )); ?>


<div style='float:left;padding-right:5px'>
    <?php $this->widget('application.modules.social.widgets.ysc.yandex.YandexShareApi', array(
    'type' => 'button',
    'services' => 'all'
));?>
</div>
