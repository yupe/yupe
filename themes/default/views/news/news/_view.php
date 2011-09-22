<div class="post">
    <div class="title">
        <?php echo CHtml::link(CHtml::encode($data->title), array('/news/news/show', 'title' => $data->alias)); ?>
    </div>
    <div class="author">
        Опубликовал <b><?php echo $data->user->nickName?></b>
        дата: <?php echo $data->creationDate; ?>
    </div>
    <br/>

    <div class="content">
        <p><?php echo $data->fullText; ?></p>
    </div>
    <div class="nav">
        <?php echo CHtml::link('Постоянная ссылка', array('/news/news/show', 'title' => $data->alias));?>
        | последнее обновление <?php echo $data->changeDate;?>
    </div>
</div>

<div style='float:left;padding-right:5px'>
    <?php $this->widget('application.modules.yupe.widgets.ysc.yandex.YandexShareApi', array(
                                                                                              'type' => 'button',
                                                                                              'services' => 'all'
                                                                                         ));?>
</div>

<br/><br/><br/>

<?php $this->widget('application.modules.comment.widgets.CommentsListWidget', array('model' => $data, 'modelId' => $data->id)); ?>

<br/>

<h3>Оставить комментарий</h3>

<?php $this->widget('application.modules.comment.widgets.CommentFormWidget', array('redirectTo' => $data->getPermaLink(), 'model' => $data, 'modelId' => $data->id)); ?>
