<?php
/**
 * @var $this PostController
 */

$this->title = $post->title;
$this->description = !empty($post->description) ? $post->description : strip_tags($post->getQuote());
$this->keywords = !empty($post->keywords) ? $post->keywords : implode(', ', $post->getTags());

Yii::app()->clientScript->registerScript(
    "ajaxBlogToken",
    "var ajaxToken = " . json_encode(
        Yii::app()->getRequest()->csrfTokenName . '=' . Yii::app()->getRequest()->csrfToken
    ) . ";",
    CClientScript::POS_BEGIN
);

$this->breadcrumbs = [
    Yii::t('BlogModule.blog', 'Blogs') => ['/blog/blog/index/'],
    CHtml::encode($post->blog->name) => ['/blog/blog/view', 'slug' => $post->blog->slug],
    $post->title,
];
?>
