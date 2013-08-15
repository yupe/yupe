<?php $this->pageTitle = 'Фото'; ?>
<?php $this->breadcrumbs = array(
    'Галереи' => array('/gallery/gallery/list'),
    $model->name
);
?>

<div class="row">
    <div class="span8">
        <h4><?php echo CHtml::encode($model->name); ?></h4>
    </div>
</div>

<div class="row">
    <div class="span8">
        <?php echo CHtml::image($model->getUrl(), $model->name, array('width' => 500)); ?>
    </div>
</div>

<div class="row">
    <div class="span8">
        <p></p>
        <p>
            <i class="icon-user"></i> <?php echo CHtml::link($model->user->nick_name, array('/user/people/userInfo', 'username' => $model->user->nick_name)); ?>
            | <i class="icon-calendar"></i> <?php echo Yii::app()->getDateFormatter()->formatDateTime($model->creation_date, "short", "short"); ?>
        </p>
        <p><?php echo CHtml::encode($model->description); ?></p>
    </div>
</div>


<br/>

<?php $this->widget('application.modules.comment.widgets.CommentsListWidget', array('model' => $model, 'modelId' => $model->id)); ?>

<?php $this->widget('application.modules.comment.widgets.CommentFormWidget', array('redirectTo' => $this->createUrl('/gallery/gallery/foto/', array('id' => $model->id)), 'model' => $model, 'modelId' => $model->id)); ?>

