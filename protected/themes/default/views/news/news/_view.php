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
        <p><?php echo $data->short_text; ?></p>
    </div>
    <div class="nav">
        <?php echo CHtml::link('Постоянная ссылка', array('/news/news/show', 'title' => $data->alias));?>
        | последнее обновление <?php echo $data->change_date;?>
    </div>
</div>