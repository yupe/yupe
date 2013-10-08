<?php $this->pageTitle = $blog->name; ?>
<?php $this->description = $blog->description; ?>

<?php
$this->breadcrumbs = array(
    Yii::t('blog', 'Блоги') => array('/blog/blog/index/'),
    $blog->name,
);
?>

<div class="row-fluid">

    <div class='span3'>
        <?php echo CHtml::image($blog->getImageUrl(),$blog->name,
            array(
                'width'  => 64,
                'height' => 64
            )
        ); ?>
    </div>

    <div class='span6'>

        <i class="icon-pencil"></i> <?php echo CHtml::link($blog->name, array('/blog/post/blog/','slug' => $blog->slug)); ?>
        <a href="<?php echo Yii::app()->createUrl('/blog/rss/feed/',array('blog' => $blog->id));?>"><img src="<?php echo Yii::app()->AssetManager->publish("../".Yii::app()->theme->baseUrl."/web/images/rss.png"); ?>" alt="Подпишитесь на обновление блога '<?php echo $blog->name?>'" title="Подпишитесь на обновление блога '<?php echo $blog->name?>'"></a>
        <br/>

        <i class="icon-user"></i> <?php echo Yii::t('blog', 'Создал'); ?>: <b><?php echo CHtml::link($blog->createUser->nick_name, array('/user/people/userInfo/','username' => $blog->createUser->nick_name));?></b><br/>

        <i class="icon-calendar"></i> <?php echo Yii::t('blog', 'Дата'); ?>: <?php echo Yii::app()->getDateFormatter()->formatDateTime($blog->create_date, "short", "short"); ?></br>

        <i class="icon-pencil"></i> <?php echo CHtml::link($blog->postsCount, array('/blog/post/blog/','slug' => $blog->slug)); ?> </br></br>
    </div>
</div>

    <div class="content">
        <p><?php echo $blog->description; ?></p>
    </div>

<?php $this->widget('blog.widgets.MembersOfBlogWidget', array('blogId' => $blog->id)); ?>

<?php $this->widget('blog.widgets.LastPostsOfBlogWidget', array('blogId' => $blog->id, 'limit' => 3)); ?>

<?php $this->widget('application.modules.blog.widgets.ShareWidget');?>
<br /><br />

<?php $this->widget('application.modules.comment.widgets.CommentsListWidget', array('model' => $blog, 'modelId' => $blog->id)); ?>

<h3><?php echo Yii::t('blog', 'Оставить комментарий'); ?></h3>

<?php $this->widget('application.modules.comment.widgets.CommentFormWidget', array(
    'redirectTo' => Yii::app()->createUrl('/blog/blog/show/', array('slug' => $blog->slug)),
    'model' => $blog,
    'modelId' => $blog->id,
)); ?>