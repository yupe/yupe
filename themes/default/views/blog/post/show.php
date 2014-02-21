<?php
    $this->pageTitle = $post->title;
    $this->description = !empty($post->description) ? $post->description : strip_tags($post->getQuote());
    $this->keywords = !empty($post->keywords) ? $post->keywords :  implode(', ',$post->getTags());

    Yii::app()->clientScript->registerScript(
        "ajaxBlogToken", "var ajaxToken = " . json_encode(
            Yii::app()->getRequest()->csrfTokenName . '=' . Yii::app()->getRequest()->csrfToken
        ) . ";", CClientScript::POS_BEGIN
    );

    $this->breadcrumbs = array(
        Yii::t('BlogModule.blog', 'Blogs') => array('/blog/blog/index/'),
        CHtml::encode($post->blog->name) => array('/blog/blog/show/', 'slug' => CHtml::encode($post->blog->slug)),
        CHtml::encode($post->title),
    ); 
?>

<div class="post">
    <div class="row">        
        <div class="span8">       
            <h4><strong><?php echo CHtml::encode($post->title);?></strong></h4>
             <div class="posts-list-block-meta">           
                <span>
                    <i class="icon-pencil"></i>
                    <?php echo CHtml::link(
                        CHtml::encode($post->blog->name), array(
                            '/blog/blog/show/',
                            'slug' => Chtml::encode($post->blog->slug)
                        )
                    ); ?>
                </span>
                <span>
                    <i class="icon-calendar"></i>
                    <?php echo Yii::app()->getDateFormatter()->formatDateTime(
                        $post->publish_date, "long", "short"
                    ); ?>
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="span8">
            <p>
                <?php if($post->image):?>
                    <?php echo CHtml::image($post->getImageUrl());?>
                <?php endif;?>

                <?php echo $post->content; ?>
            </p>
        </div>
    </div>

    <?php if($post->link):?>
        <div>
            <i class='icon-globe'></i> <?php echo CHtml::link($post->link, $post->link, array('target' => '_blank','rel' => 'nofollow'));?>
        </div>    
    <?php endif;?>

    <?php $this->widget('blog.widgets.PostMetaWidget', array('post' => $post));?>

</div>

<br/>

<?php $this->widget('blog.widgets.SimilarPostsWidget', array('post' => $post)); ?>

<?php $this->widget('application.modules.blog.widgets.ShareWidget');?>

<hr/>

<div class="comments-section">   

    <?php
        $this->widget(
            'application.modules.comment.widgets.CommentsListWidget', array(
                'model' => $post,
                'modelId'  => $post->id,
                'comments' => $post->comments
            )
        ); 
    ?>

     <?php
        $this->widget(
            'application.modules.comment.widgets.CommentFormWidget', array(
                'redirectTo' => $this->createUrl('/blog/post/show/', array('slug' => $post->slug)),
                'model' => $post,
                'modelId' => $post->id,
            )
        );
    ?>

</div>