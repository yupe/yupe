<?php
$this->pageTitle = $post->title;
$this->description = $post->description;
$this->keywords = $post->keywords;

Yii::app()->clientScript->registerScript(
    "ajaxBlogToken", "var ajaxToken = " . json_encode(
        Yii::app()->request->csrfTokenName . '=' . Yii::app()->request->csrfToken
    ) . ";", CClientScript::POS_BEGIN
);

$this->breadcrumbs = array(
    Yii::t('blog', 'Блоги') => array('/blog/blog/index/'),
    CHtml::encode($post->blog->name) => array('/blog/blog/show/', 'slug' => $post->blog->slug),
    CHtml::encode($post->title),
); ?>

<div class="post">
    <div class="row">
        <div class="span8">
            <h4><strong><?php echo CHtml::encode($post->title);?></strong></h4>
        </div>
    </div>
    <div class="row">
        <div class="span8">
            <p> <?php echo $post->content; ?></p>
        </div>
    </div>

    <div class="row">
        <div class="span8">
            <p></p>
            <p>
                <i class="icon-user"></i> <?php echo CHtml::link($post->createUser->nick_name, array('/user/people/userInfo', 'username' => $post->createUser->nick_name)); ?>
                | <i class="icon-pencil"></i> <?php echo CHtml::link($post->blog->name, array('/blog/blog/show/', 'slug' => $post->blog->slug)); ?>
                | <i class="icon-calendar"></i> <?php echo Yii::app()->getDateFormatter()->formatDateTime($post->publish_date, "long", "short"); ?>
                | <i class="icon-comment"></i>  <?php echo CHtml::link($post->commentsCount, array('/blog/post/show/', 'slug' => $post->slug, '#' => 'comments'));?>
                | <i class="icon-tags"></i>
                <?php if (($tags = $post->getTags()) != array()):?>
                    <?php foreach ($tags as $tag):?>
                        <?php $tag = CHtml::encode($tag);?>
                        <span class="label label-info">
                            <?php echo CHtml::link($tag, array('/posts/', 'tag' => $tag)).' '?>
                        </span>
                    <?php endforeach?>
                <?php endif;?>
            </p>
        </div>
    </div>

</div>

<?php $this->widget('blog.widgets.SimilarPostsWidget', array('post' => $post)); ?>

<script type="text/javascript">
    (function() {
        if(window.pluso) if(typeof window.pluso.start == "function") return;
        var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
        s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
        s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
        var h=d[g]('head')[0] || d[g]('body')[0];
        h.appendChild(s);
    })();
</script>
<div class="pluso" data-options="small,round,line,horizontal,counter,theme=04" data-services="vkontakte,odnoklassniki,facebook,twitter,google,moimir,email,print" data-background="transparent"></div>

<br /><br />

<?php
$this->widget(
    'application.modules.comment.widgets.CommentsListWidget', array(
        'model' => $post,
        'modelId'  => $post->id,
        'comments' => $post->comments
    )
); ?>

<br/>

<b><?php echo Yii::t('BlogModule.blog', 'Оставить комментарий'); ?></b>

<?php
$this->widget(
    'application.modules.comment.widgets.CommentFormWidget', array(
        'redirectTo' => $this->createUrl('/blog/post/show/', array('slug' => $post->slug)),
        'model' => $post,
        'modelId' => $post->id,
    )
); ?>