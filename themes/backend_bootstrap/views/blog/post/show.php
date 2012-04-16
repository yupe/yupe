<div class="post">
    <div class="title">
        <?php echo CHtml::link(CHtml::encode($post->title), array('/blog/post/show/', 'slug' => $post->slug)); ?>
    </div>
    <div class="author">
        Опубликовал <b><?php echo $post->createUser->nick_name?></b>
        дата: <?php echo $post->create_date; ?>
    </div>
    <br/>

    <div class="content">
        <p><?php echo $post->content; ?></p>
    </div>
    <div class="nav">        
        <?php echo $post->tags->toString(); ?>        
        | <?php echo CHtml::link('Постоянная ссылка', array('/blog/post/show/', 'slug' => $post->slug));?>
        | обновлено <?php echo $post->update_date;?>
    </div>
</div>

<div style='float:left;padding-right:5px'>
    <?php $this->widget('application.modules.social.widgets.ysc.yandex.YandexShareApi', array(
                                                                                              'type' => 'button',
                                                                                              'services' => 'all'
                                                                                         ));?>
</div>

