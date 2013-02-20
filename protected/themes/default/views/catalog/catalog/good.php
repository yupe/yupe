<?php $this->pageTitle = $good->name; ?>

<?php
$this->breadcrumbs = array(
    'Товар' => array('/catalog/catalog/index/'),
    CHtml::encode($good->name)
);
?>

<div class="post">
    <div class="title">
        <?php echo $good->name; ?>
    </div>
    <br/>
    <div class="content">
        <p><?php echo $good->description; ?></p>
    </div>
    <div class="nav">
        Цена: <?php echo $good->price; ?>
        <br/>
        <?php echo CHtml::link('Постоянная ссылка', array('/news/news/show', 'name' => $good->alias));?>
    </div>
</div>


<br/><br/><br/>

<?php $this->widget('application.modules.comment.widgets.CommentsListWidget', array('model' => $good, 'modelId' => $good->id)); ?>

<br/>

<h3>Оставить комментарий</h3>

<?php $this->widget('application.modules.comment.widgets.CommentFormWidget', array('redirectTo' => $good->getPermaLink(), 'model' => $good, 'modelId' => $good->id)); ?>
