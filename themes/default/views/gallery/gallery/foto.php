<?php $this->pageTitle = 'Фото'; ?>
<?php $this->breadcrumbs = array('Галереи' => array('/gallery/gallery/list'),$model->name); ?>

<h1><?php echo CHtml::encode($model->name);?></h1>

<?php echo CHtml::image($model->getUrl(), $model->name, array('width' => 500)); ?>

<br/><br/>

<p><?php echo CHtml::encode($model->description);?></p>

<br/><br/><br/>

<?php $this->widget('application.modules.comment.widgets.CommentsListWidget', array('model' => $model, 'modelId' => $model->id)); ?>

<br/>

<?php if (Yii::app()->user->isAuthenticated()): ?>

<h3>Оставить комментарий</h3>

<?php $this->widget('application.modules.comment.widgets.CommentFormWidget', array('redirectTo' => $this->createUrl('/gallery/gallery/foto/', array('id' => $model->id)), 'model' => $model, 'modelId' => $model->id)); ?>

<?php else: ?>

Для комментирования, пожалуйста, <?php echo CHtml::link('авторизуйтесь', array('/user/account/login/')); ?>...

<?php endif; ?>