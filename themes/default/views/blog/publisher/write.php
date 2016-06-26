<?php
$this->title = Yii::t('BlogModule.blog', 'Write post!');
$this->breadcrumbs = [
    Yii::t('BlogModule.blog', 'Blogs') => ['/blog/blog/index/'],
    Yii::t('BlogModule.blog', 'My posts') => ['/blog/publisher/my'],
    Yii::t('BlogModule.blog', 'Write post!')
];

$this->renderPartial('_form', [
    'model' => $post,
    'blogs' => $blogs,
    'tags' => $tags
]);
