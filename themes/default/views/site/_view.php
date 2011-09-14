<div class="post">
    <div class="title">
        <?php echo CHtml::link(CHtml::encode($data->title), array('/news/news/show', 'title' => $data->alias)); ?>
    </div>
    <div class="author">
        Опубликовал <b><?php echo $data->user->nickName?></b>
        дата: <?php echo $data->creationDate; ?>
    </div>
    <div class="content">
        <p><?php echo $data->shortText; ?></p>
    </div>
    <div class="nav">
        <?php echo CHtml::link('Постоянная ссылка', array('/news/news/show', 'title' => $data->alias));?>
        | последнее обновление <?php echo $data->changeDate;?>
    </div>
</div>
