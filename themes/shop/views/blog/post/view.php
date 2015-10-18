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
