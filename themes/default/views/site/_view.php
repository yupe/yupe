<div class="post">
    <div class="title">
        <?php echo CHtml::link(CHtml::encode($data->title), array('/blog/post/show/', 'slug' => $data->slug)); ?>
    </div>
    <div class="author">
        Опубликовал <b><?php echo $data->createUser->nick_name?></b>
        в блоге "<?php echo CHtml::link($data->blog->name,array('/blog/blog/show/','slug' => $data->blog->slug))?>"
        дата: <?php echo $data->publish_date; ?>
    </div>
    <div class="content">
        <p><?php echo $data->quote; ?></p>
    </div>
    <div class="nav">
        <?php echo CHtml::link('Постоянная ссылка', array('/blog/post/show/', 'slug' => $data->slug));?>
        | последнее обновление <?php echo $data->publish_date;?>
    </div>
</div>
