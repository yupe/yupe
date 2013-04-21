<?php $this->pageTitle = $blog->name; ?>
<?php $this->description = $blog->description; ?>

<?php
$this->breadcrumbs = array(
    Yii::t('blog', 'Блоги') => array('/blog/blog/index/'),
    $blog->name,
);
?>

<div class="post">

    <div class="title">
        <?php echo $blog->name; ?>
    </div>

    <div>
        <?php
        echo CHtml::image(
            !empty($blog->imageUrl)
                ? $blog->imageUrl
                : Yii::app()->theme->baseUrl . '/web/images/blog-icon.png', $blog->name,
            array(
                'width'  => 64,
                'height' => 64
            )
        ); ?>
    </div>

    <br/>

    <div class="author">
        <?php echo Yii::t('blog', 'Создал'); ?>: <b><?php echo $blog->createUser->nick_name?></b>
        <?php echo Yii::t('blog', 'Дата'); ?>: <?php echo Yii::app()->getDateFormatter()->formatDateTime($blog->create_date, "short", "short"); ?>
    </div>
    <div class="content">
        <p><?php echo $blog->description; ?></p>
    </div>
</div>

<?php if(!empty($member)):?>
    <p><?php echo Yii::t('blog', 'Участники'); ?>:</p>
    <?php  foreach ($members as $member): ?>
       <?php CHtml::link($member->nick_name, array('/user/people/userInfo/', 'username' => $member->nick_name));?>
    <?php endforeach;?>
    <br /><br />
<?php endif;?>

<?php $this->renderPartial('_post_list', array('posts' => $posts)); ?>

<script type="text/javascript">(function() {
        if(window.pluso) if(typeof window.pluso.start == "function") return;
        var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
        s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
        s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
        var h=d[g]('head')[0] || d[g]('body')[0];
        h.appendChild(s);
    })();</script>
<div class="pluso" data-options="small,round,line,horizontal,counter,theme=04" data-services="vkontakte,odnoklassniki,facebook,twitter,google,moimir,email,print" data-background="transparent"></div>
<br /><br />

<?php $this->widget('application.modules.comment.widgets.CommentsListWidget', array('model' => $blog, 'modelId' => $blog->id)); ?>

<h3><?php echo Yii::t('blog', 'Оставить комментарий'); ?></h3>
<?php $this->widget('application.modules.comment.widgets.CommentFormWidget', array(
    'redirectTo' => Yii::app()->createUrl('/blog/blog/show/', array('slug' => $blog->slug)),
    'model' => $blog,
    'modelId' => $blog->id,
)); ?>