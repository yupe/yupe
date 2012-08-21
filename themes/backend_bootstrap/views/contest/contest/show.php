<h1><?php echo Yii::t('contest', 'Конкурс');?>
    "<?php echo CHtml::encode($model->name);?>"</h1>

<p><?php echo CHtml::encode($model->description);?></p>

<p><?php echo Yii::t('contest', 'Количество фото');?>
    : <?php echo $model->imagesCount;?></p>


<?php $this->widget('zii.widgets.CListView', array(
                                                  'dataProvider' => $dataProvider,
                                                  'itemView' => '_foto_view',
                                             )); ?>


<?php if (Yii::app()->user->isAuthenticated()): ?>
<div id='add-image-form'>
    <h1><?php echo Yii::t('contest', 'Добавление фото');?></h1>
    <?php $this->renderPartial('_add_foto_form', array('model' => $image, 'contest' => $model));?>
</div>
<?php else: ?>
<?php echo Yii::t('contest', 'Для участия в конкурсе Вам необходимо ') ?> <?php echo CHtml::link(Yii::t('gallery', 'авторизоваться'), array('/user/account/login/')); ?>!
<?php endif; ?>

