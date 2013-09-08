<?php $this->pageTitle = $model->name; ?>
<?php $this->breadcrumbs = array(
    'Галереи' => array('/gallery/gallery/list'),
    $model->name
);
?>

<h4>
    <small>
        <?php echo CHtml::encode($model->name); ?>
    </small>
</h4>

<div class="thumbnail">
    <div class="row">
        <div class="span8">
            <?php echo CHtml::image($model->getUrl(), $model->name); ?>
        </div>
    </div>
</div>

<br/>

<div class="row">
    <div class="span8">
        <p>
            <?php echo CHtml::image($model->user->getAvatar(16), $model->user->nick_name);?> <?php echo CHtml::link($model->user->nick_name, array('/user/people/userInfo', 'username' => $model->user->nick_name)); ?>
            <i class="icon-calendar"></i> <?php echo Yii::app()->getDateFormatter()->formatDateTime($model->creation_date, "short", "short"); ?>
        </p>
    </div>
</div>

<br/>

<blockquote>
    <p><?php echo CHtml::encode($model->description); ?></p>
</blockquote>

<br/>

<?php $this->widget('application.modules.comment.widgets.CommentsListWidget', array('model' => $model, 'modelId' => $model->id)); ?>

<?php $this->widget('application.modules.comment.widgets.CommentFormWidget', array('redirectTo' => $this->createUrl('/gallery/gallery/foto/', array('id' => $model->id)), 'model' => $model, 'modelId' => $model->id)); ?>

