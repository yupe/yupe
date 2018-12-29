<?php
/**
 * Отображение для ./themes/default/views/news/news/news.php:
 *
 * @category YupeView
 * @package  YupeCMS
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     https://yupe.ru
 *
 * @var $this NewsController
 * @var $model News
 **/
?>
<?php
$this->title = $model->meta_title ?: $model->title;
$this->description = $model->meta_description;
$this->keywords = $model->meta_keywords;
?>

<?php
$this->breadcrumbs = [
    Yii::t('NewsModule.news', 'News') => ['/news/news/index'],
    $model->title
];
?>
<div class="main__title grid">
    <h1 class="h2"><?= CHtml::encode($model->title); ?></h1>
</div>
<div class="main__catalog grid fast-order__inputs">
    <?php if ($model->image): ?>
        <?= CHtml::image($model->getImageUrl(), $model->title); ?>
    <?php endif; ?>
    <p> <?= $model->full_text; ?></p>
</div>
