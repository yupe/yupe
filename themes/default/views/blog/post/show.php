<?php
/**
 * Отображение для post/show:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$this->pageTitle = $post->title;
//$this->description = $post->description;
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

<?php $this->widget('blog.widgets.SimilarPostsWidget', array('post' => $post)); ?>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $(document).on('click', '.post-updatecomments', function(){
            var link = $(this);
            var postID = link.attr('rel');
            link.addClass('ajax-loading');
            $.ajax({
                url: '<?php echo Yii::app()->baseUrl;?>/blog/post/updatecomments',
                data: ajaxToken + '&postID=' + postID,
                dataType: 'json',
                type: 'post',
                success: function(data){
                    if (data.result && data.data.content) {
                        $('#comments').replaceWith(data.data.content);
                        $('#comments').before(
                            "<div class='flash'><div class='flash-success'><b>" + data.data.message + "</b></div></div>"
                        );
                    } else {
                        $('.comments').before("<div class='flash'><div class='flash-error'><b>" + data.data.message + "</b></div></div>");
                    }
                    link.removeClass('ajax-loading');
                }
            });
            setTimeout(function(){
                $('.flash').remove();
            }, 3000);
            return false;
        });
    });
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

<br/><br />

<?php
echo CHtml::link(
    Yii::t('BlogModule.blog', 'Обновить комментарии'), 'javascript:void(0);', array(
        'class' => 'post-updatecomments',
        'rel'   => $post->id
    )
); ?>

<?php
$this->widget(
    'application.modules.comment.widgets.CommentsListWidget', array(
        'model' => $post,
        'modelId'  => $post->id,
        'comments' => $post->comments
    )
); ?>

<br/><br/>
<b><?php echo Yii::t('BlogModule.blog', 'Оставить комментарий'); ?></b>
<br/><br/>

<?php
$this->widget(
    'application.modules.comment.widgets.CommentFormWidget', array(
        'redirectTo' => $this->createUrl('/blog/post/show/', array('slug' => $post->slug)),
        'model' => $post,
        'modelId' => $post->id,
    )
); ?>