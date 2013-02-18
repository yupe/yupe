<?php //$this->pageTitle = 'Галерея'; ?>
<?php //$this->breadcrumbs = array('Галереи' => array('/gallery/gallery/list'),$model->name); ?>
<!---->
<!--<h1>--><?php //echo Yii::t('gallery', 'Галерея');?>
<!--    "--><?php //echo CHtml::encode($model->name);?><!--"</h1>-->
<!---->
<!--<p>--><?php //echo CHtml::encode($model->description);?><!--</p>-->
<!---->
<!--<p>--><?php //echo Yii::t('gallery', 'Количество изображений');?>
<!--    : --><?php //echo $model->imagesCount;?><!--</p>-->
<!---->
<?php //$this->widget('zii.widgets.CListView', array(
//                                                  'dataProvider' => $dataProvider,
//                                                  'itemView' => '_foto_view',
//                                             )); ?>
<!---->
<!---->
<!--<div style='float:left;padding-right:5px'>-->
<!--    --><?php //$this->widget('application.modules.social.widgets.ysc.yandex.YandexShareApi', array(
//    'type' => 'button',
//    'services' => 'all'
//));?>
<!--</div>-->

<h1>
    <?php echo Yii::t('GalleryModule.gallery', 'Галерея'); ?>
    "<?php echo CHtml::encode($model->name); ?>"
</h1>

<?php echo $model->description; ?>

<p><?php echo Yii::t('GalleryModule.gallery', 'Количество фото'); ?>
    : <?php echo $model->imagesCount; ?></p>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView'     => '_foto_view',
)); ?>

<?php if (Yii::app()->user->isAuthenticated()): ?>
<div id="add-image-form">
    <h1><?php echo Yii::t('GalleryModule.gallery', 'Добавление фото'); ?></h1>
    <?php $this->renderPartial('_add_foto_form', array('model' => $image, 'gallery' => $model)); ?>
</div>
<?php else: ?>
<?php echo Yii::t('GalleryModule.gallery', 'Для добавления фото Вам необходимо ') ?>
<?php echo CHtml::link(Yii::t('GalleryModule.gallery', 'авторизоваться'), array('/user/account/login/')); ?>!
<?php endif; ?>
