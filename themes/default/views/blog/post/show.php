<?php $this->pageTitle = $post->title;?>
<?php $this->description = $post->description;?>
<?php $this->keywords = $post->keywords;?>

<div class="post">
    <div class="title">
        <?php echo CHtml::link(CHtml::encode($post->title), array('/blog/post/show/', 'slug' => $post->slug)); ?>
    </div>
    <div class="author">
        Опубликовал <b><?php echo $post->createUser->nick_name?></b>
        в блоге "<?php echo CHtml::link($post->blog->name,array('/blog/blog/show/','slug' => $post->blog->slug))?>"
        дата: <?php echo $post->publish_date; ?>
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


<br/><br/><br/>

<?php $this->widget('application.modules.comment.widgets.CommentsListWidget', array('model' => $post, 'modelId' => $post->id)); ?>

<br/>

<h3>Оставить комментарий</h3>

<?php $this->widget('application.modules.comment.widgets.CommentFormWidget', array('redirectTo' => $this->createUrl('/blog/post/show/', array('slug' => $post->slug)), 'model' => $post, 'modelId' => $post->id)); ?>


