<h1><?php echo Yii::t('gallery', 'Галерея');?>
    "<?php echo CHtml::encode($model->name);?>"</h1>

<p><?php echo CHtml::encode($model->description);?></p>

<p><?php echo Yii::t('gallery', 'Количество изображений');?>
    : <?php echo $model->imagesCount;?></p>

<?php $this->widget('zii.widgets.CListView', array(
                                                  'dataProvider' => $dataProvider,
                                                  'itemView' => '_foto_view',
                                             )); ?>


<div style='float:left;padding-right:5px'>
    <?php $this->widget('application.modules.social.widgets.ysc.yandex.YandexShareApi', array(
    'type' => 'button',
    'services' => 'all'
));?>
</div>
