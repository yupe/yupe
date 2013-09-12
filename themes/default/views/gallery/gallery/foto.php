<?php $this->pageTitle = $model->name; ?>
<?php $this->breadcrumbs = array(
    'Галереи' => array('/gallery/gallery/list'),
    $model->name
);
?>
<h1 class="page-header"><?php echo CHtml::encode($model->name); ?></h1>

<div class="thumbnail">
    <?php echo CHtml::image($model->getUrl(), $model->name); ?>
</div>
<hr>
<p>
    <?php echo CHtml::image($model->user->getAvatar(16), $model->user->nick_name);?> <?php echo CHtml::link($model->user->nick_name, array('/user/people/userInfo', 'username' => $model->user->nick_name)); ?>
    <i class="icon-calendar"></i> <?php echo Yii::app()->getDateFormatter()->format('dd MMMM yyyy г., hh:mm', $model->creation_date); ?>
</p>



<blockquote>
    <p><?php echo CHtml::encode($model->description); ?></p>
</blockquote>


<?php $this->widget('application.modules.comment.widgets.CommentsListWidget', array('model' => $model, 'modelId' => $model->id)); ?>

<?php $this->widget('application.modules.comment.widgets.CommentFormWidget', array('redirectTo' => $this->createUrl('/gallery/gallery/foto/', array('id' => $model->id)), 'model' => $model, 'modelId' => $model->id)); ?>

