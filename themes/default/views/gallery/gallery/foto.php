<h1><?php echo CHtml::encode($model->name);?></h1>

<?php echo CHtml::image($model->file, $model->name, array('width' => 500, 'height' => 500)); ?>

<br/><br/>

<p><?php echo CHtml::encode($model->description);?></p>

<br/>

<div style='float:left;padding-right:5px'>
    <?php $this->widget('application.modules.social.widgets.ysc.yandex.YandexShareApi', array(
    'type' => 'button',
    'services' => 'all'
));?>
</div>

<br/><br/><br/><br/>

<?php $this->widget('application.modules.comment.widgets.CommentsListWidget', array('model' => $model, 'modelId' => $model->id)); ?>

<br/>

<?php if (Yii::app()->user->isAuthenticated()): ?>

<h3>Оставить комментарий</h3>

<?php $this->widget('application.modules.comment.widgets.CommentFormWidget', array('redirectTo' => $this->createUrl('/gallery/gallery/foto/', array('id' => $model->id)), 'model' => $model, 'modelId' => $model->id)); ?>

<?php else: ?>

Для комментирования, пожалуйста, <?php echo CHtml::link('авторизуйтесь', array('/user/account/login/')); ?>...

<?php endif; ?>