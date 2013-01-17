<?php $this->pageTitle = $news->title; ?>

<?php
$this->breadcrumbs = array(
    'Новости' => array('/news/default/index/'),
    CHtml::encode($news->title)
);
?>

<div class="post">
    <div class="title">
        <?php echo $news->title; ?>
    </div>
    <div class="author">
        Опубликовал <b><?php echo $news->user->nick_name?></b>
        дата: <?php echo $news->creation_date; ?>
    </div>
    <br/>

    <div class="content">
        <p><?php echo $news->full_text; ?></p>
    </div>
    <div class="nav">
        <?php echo CHtml::link('Постоянная ссылка', array('/news/default/show', 'title' => $news->alias));?>
        | последнее обновление <?php echo $news->change_date;?>
    </div>
</div>


<br/><br/><br/>

<?php $this->widget('application.modules.comment.widgets.CommentsListWidget', array('model' => $news, 'modelId' => $news->id)); ?>

<br/>

<h3>Оставить комментарий</h3>

<?php $this->widget('application.modules.comment.widgets.CommentFormWidget', array('redirectTo' => $news->getPermaLink(), 'model' => $news, 'modelId' => $news->id)); ?>
