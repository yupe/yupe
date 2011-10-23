<div class="post">
    <div class="title">
        <?php echo CHtml::link(CHtml::encode($data->title), array('/news/news/show', 'title' => $data->alias)); ?>
    </div>
    <div class="author">
        Опубликовал <b><?php echo $data->user->nick_name?></b>
        дата: <?php echo $data->creation_date; ?>
    </div>
    <br/>

    <div class="content">
        <p><?php echo $data->full_text; ?></p>
    </div>
    <div class="nav">
        <?php echo CHtml::link('Постоянная ссылка', array('/news/news/show', 'title' => $data->alias));?>
        | последнее обновление <?php echo $data->change_date;?>
    </div>
</div>

<div style='float:left;padding-right:5px'>
    <?php $this->widget('application.modules.social.widgets.ysc.yandex.YandexShareApi', array(
                                                                                              'type' => 'button',
                                                                                              'services' => 'all'
                                                                                         ));?>
</div>

<br/><br/><br/>

<?php $this->widget('application.modules.comment.widgets.CommentsListWidget', array('model' => $data, 'model_id' => $data->id)); ?>

<br/>

<h3>Оставить комментарий</h3>

<?php $this->widget('application.modules.comment.widgets.CommentFormWidget', array('redirectTo' => $data->getPermaLink(), 'model' => $data, 'model_id' => $data->id)); ?>
