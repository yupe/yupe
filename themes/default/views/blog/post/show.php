<?php
$this->pageTitle = $post->title;
$this->description = $post->description;
$this->keywords = $post->keywords;
$this->breadcrumbs = array(
    'Блоги' => array('/blog/blog/index/'),
    CHtml::encode($post->blog->name) => array('/blog/blog/show/', 'slug' => $post->blog->slug),
    CHtml::encode($post->title),
);
?>

<div class="post">
    <div class="title">
        <?php echo CHtml::link(CHtml::encode($post->title), array('/blog/post/show/', 'slug' => $post->slug)); ?>
    </div>
    <div class="author">
        Опубликовал
        <b><?php echo CHtml::link($post->createUser->nick_name, array('/user/people/userInfo', 'username' => $post->createUser->nick_name)); ?></b>
        в блоге "<?php echo CHtml::link($post->blog->name, array('/blog/blog/show/', 'slug' => $post->blog->slug))?>"
        дата: <?php echo Yii::app()->getDateFormatter()->formatDateTime($post->publish_date, "short", null);; ?>
    </div>
    <br/>

    <div class="content">
        <p><?php echo $post->content; ?></p>
    </div>
    <div class="nav">
        <?php foreach ($post->getTags() as $tag): ?>
            <?php echo CHtml::link(CHtml::encode($tag), array('/posts/', 'tag' => CHtml::encode($tag))); ?>
        <?php endforeach;?>
        | Обновлено <?php echo Yii::app()->getDateFormatter()->formatDateTime($post->update_date, "short", "short"); ?>
    </div>
</div>

<div style='float:left;padding-right:5px'>
<?php $this->widget('application.modules.social.widgets.ysc.yandex.YandexShareApi', array(
    'type' => 'button',
    'services' => 'all',
)); ?>
</div>


<br/><br/><br/>

<?php $this->widget('application.modules.comment.widgets.CommentsListWidget', array('model' => $post, 'modelId' => $post->id)); ?>

<br/>

<h3>Оставить комментарий</h3>

<?php $this->widget('application.modules.comment.widgets.CommentFormWidget', array(
    'redirectTo' => $this->createUrl('/blog/post/show/', array('slug' => $post->slug)),
    'model' => $post,
    'modelId' => $post->id,
)); ?>