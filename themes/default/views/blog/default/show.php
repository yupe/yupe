<?php $this->pageTitle = $blog->name; ?>
<?php $this->description = $blog->description; ?>

<?php
$this->breadcrumbs = array(
    Yii::t('blog', 'Блоги') => array('/blogs'),
    $blog->name,
);
?>

<div class="post">
    <div class="title">
        <?php echo $blog->name; ?>
    </div>
    <div class="author">
        <?php echo Yii::t('blog', 'Создал'); ?>: <b><?php echo $blog->createUser->nick_name?></b>
        <?php echo Yii::t('blog', 'Дата'); ?>: <?php echo Yii::app()->getDateFormatter()->formatDateTime($blog->create_date, "short", "short"); ?>
    </div>
    <div class="content">
        <p><?php echo $blog->description; ?></p>
    </div>
</div>

<p><?php echo Yii::t('blog', 'Участники'); ?>:</p>
<?php
if ($members)
    foreach ($members as $member)
        echo CHtml::link($member->nick_name, array('/user/'.$member->nick_name));
?>
<br /><br />

<p><?php echo Yii::t('blog', 'Последние записи'); ?>:</p>
<?php if (count($posts)): ?>
    <ul>
        <?php foreach ($posts as $post): ?>
            <li>
                <?php echo CHtml::link($post->title, array('/blog/post/show/', 'slug' => $post->slug)); ?> 
                - <?php echo Yii::app()->getDateFormatter()->formatDateTime($post->publish_date, "short", null); ?>
            </li>
        <?php endforeach;?>
    </ul>
<?php endif; ?>

<div style="float:left;padding-right:5px">
    <?php $this->widget('application.modules.social.widgets.ysc.yandex.YandexShareApi', array(
        'type' => 'button',
        'services' => 'all',
    )); ?>
</div>
<br /><br />

<?php $this->widget('application.modules.comment.widgets.CommentsListWidget', array('model' => $blog, 'modelId' => $blog->id)); ?>
<br /><br />

<h3><?php echo Yii::t('blog', 'Оставить комментарий'); ?></h3>
<?php $this->widget('application.modules.comment.widgets.CommentFormWidget', array(
    'redirectTo' => Yii::app()->createUrl('/blog/blog/show/', array('slug' => $blog->slug)),
    'model' => $blog,
    'modelId' => $blog->id,
)); ?>