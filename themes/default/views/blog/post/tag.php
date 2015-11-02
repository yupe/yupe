<?php
/**
 * @var $this PostController
 */

$this->title = [Yii::t('BlogModule.blog', 'Posts list with tag "{tag}"', ['{tag}' => CHtml::encode($tag)]), Yii::app()->getModule('yupe')->siteName]; ?>

<?php $this->breadcrumbs = [
    Yii::t('BlogModule.blog', 'Blogs') => ['/blog/blog/index/'],
    Yii::t('BlogModule.blog', 'Posts list'),
]; ?>

<p><?= Yii::t('BlogModule.blog', 'Posts with tag'); ?> <strong><?= CHtml::encode($tag); ?></strong>...</p>

<?php foreach ($posts as $post): ?>
    <?php $this->renderPartial('_item', ['data' => $post]); ?>
<?php endforeach; ?>
