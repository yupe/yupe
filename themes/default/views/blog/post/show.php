<?php
$this->pageTitle = $post->title;
$this->description = $post->description;
$this->keywords = $post->keywords;
$this->breadcrumbs = array(
    Yii::t('blog', 'Блоги') => array('/blog/blog/index/'),
    CHtml::encode($post->blog->name) => array('/blog/blog/show/', 'slug' => $post->blog->slug),
    CHtml::encode($post->title),
);
?>

<div class="post">
    <div class="title">
        <?php echo CHtml::link(CHtml::encode($post->title), array('/blog/post/show/', 'slug' => $post->slug)); ?>
    </div>
    <div class="author">
        <?php echo Yii::t('blog', 'Опубликовал'); ?>:
        <b><?php echo CHtml::link($post->createUser->nick_name, array('/user/people/userInfo', 'username' => $post->createUser->nick_name)); ?></b>

        <?php echo Yii::t('blog', 'в блоге'); ?>:
        "<?php echo CHtml::link($post->blog->name, array('/blog/blog/show/', 'slug' => $post->blog->slug)); ?>"

        <?php echo Yii::t('blog', 'дата'); ?>:
        <?php echo Yii::app()->getDateFormatter()->formatDateTime($post->publish_date, "short", "short"); ?>
    </div>
    <br />

    <div class="content">
        <p><?php echo $post->content; ?></p>
    </div>
    <div class="nav">
        <?php
        foreach ($tags = $post->getTags() as $tag)
            echo CHtml::link(CHtml::encode($tag), array('/posts/', 'tag' => CHtml::encode($tag))).' ';
        ?>
        | <?php echo Yii::t('blog', 'Обновлено'); ?>:
        <?php echo Yii::app()->getDateFormatter()->formatDateTime($post->update_date, "short", "short"); ?>
    </div>
</div>

<br /><br />

<?php $this->widget('application.modules.comment.widgets.CommentsListWidget', array('model' => $post, 'modelId' => $post->id)); ?>
<br/><br />

<h3><?php echo Yii::t('blog', 'Оставить комментарий'); ?></h3>
<?php $this->widget('application.modules.comment.widgets.CommentFormWidget', array(
    'redirectTo' => $this->createUrl('/blog/post/show/', array('slug' => $post->slug)),
    'model' => $post,
    'modelId' => $post->id,
)); ?>