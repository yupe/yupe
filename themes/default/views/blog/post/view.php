<?php
/**
 * @var $this PostController
 */

$this->title = [$post->title, Yii::app()->getModule('yupe')->siteName];
$this->metaDescription = !empty($post->description) ? $post->description : strip_tags($post->getQuote());
$this->metaKeywords = !empty($post->keywords) ? $post->keywords : implode(', ', $post->getTags());

Yii::app()->clientScript->registerScript(
    "ajaxBlogToken",
    "var ajaxToken = " . json_encode(
        Yii::app()->getRequest()->csrfTokenName . '=' . Yii::app()->getRequest()->csrfToken
    ) . ";",
    CClientScript::POS_BEGIN
);

$this->breadcrumbs = [
    Yii::t('BlogModule.blog', 'Blogs') => ['/blog/blog/index/'],
    CHtml::encode($post->blog->name)   => $post->blog->getUrl(),
    $post->title,
];
?>

<div class="post">
    <div class="row">
        <div class="col-sm-12">
            <h4><strong><?= CHtml::encode($post->title); ?></strong></h4>

            <div class="posts-list-block-meta">
                <span>
                    <i class="glyphicon glyphicon-pencil"></i>
                    <?= CHtml::link(
                        CHtml::encode($post->blog->name),
                        $post->blog->getUrl()
                    ); ?>
                </span>
                <span>
                    <i class="glyphicon glyphicon-calendar"></i>
                    <?= Yii::app()->getDateFormatter()->formatDateTime(
                        $post->publish_time,
                        "long",
                        "short"
                    ); ?>
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12" id="post">
            <p>
                <?php if ($post->image): ?>
                    <?= CHtml::image($post->getImageUrl()); ?>
                <?php endif; ?>

                <?= $post->content; ?>
            </p>
        </div>
    </div>

    <?php if ($post->link): ?>
        <div>
            <i class='glyphicon glyphicon-globe'></i> <?= CHtml::link(
                $post->link,
                $post->link,
                ['target' => '_blank', 'rel' => 'nofollow']
            ); ?>
        </div>
    <?php endif; ?>

    <?php $this->widget('blog.widgets.PostMetaWidget', ['post' => $post]); ?>

</div>

<br/>

<div class="post-author">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-2">
                    <?= CHtml::link(
                        $this->widget(
                            'application.modules.user.widgets.AvatarWidget',
                            ['user' => $post->createUser, 'noCache' => true, 'imageHtmlOptions' => ['width' => 100, 'height' => 100]],
                            true
                        ),
                        ['/user/people/userInfo/', 'username' => $post->createUser->nick_name]
                    ); ?>
                </div>
                <div class="col-sm-10">
                    <h4><?= Yii::t('BlogModule.blog', 'About author'); ?></h4>

                    <p>
                        <strong><?= $post->createUser->getFullName(); ?></strong>
                    </p>
                    <blockquote>
                        <?= $post->createUser->about; ?>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->widget('blog.widgets.SimilarPostsWidget', ['post' => $post]); ?>

<?php $this->widget('application.modules.blog.widgets.ShareWidget'); ?>

<hr/>

<div class="comments-section">

    <?php $this->widget('application.modules.comment.widgets.CommentsWidget', [
        'redirectTo' => $post->getUrl(),
        'model' => $post,
    ]); ?>

</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#post img').addClass('img-responsive');
        $('pre').each(function (i, block) {
            hljs.highlightBlock(block);
        });
    });
</script>

<?php $this->widget('application.modules.image.widgets.colorbox.ColorBoxWidget', [
    'targets' => [
        '#post img' => [
            'maxWidth'  => 1200,
            'maxHeight' => 800,
            'href'      => new CJavaScriptExpression("js:function(){
                    return $(this).prop('src');
                }")
        ]
    ]
]); ?>
