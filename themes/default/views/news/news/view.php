<?php
/**
 * Отображение для ./themes/default/views/news/news/news.php:
 *
 * @category YupeView
 * @package  YupeCMS
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 *
 * @var $this NewsController
 * @var $model News
 **/
?>
<?php
$this->title = [$model->title, Yii::app()->getModule('yupe')->siteName];
$this->metaDescription = $model->description;
$this->metaKeywords = $model->keywords;
?>

<?php
$this->breadcrumbs = [
    Yii::t('NewsModule.news', 'News') => ['/news/news/index'],
    $model->title
];
?>

<div class="post">
    <div class="row">
        <div class="col-sm-12">
            <h4><strong><?= CHtml::encode($model->title); ?></strong></h4>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php if ($model->image): ?>
                <?= CHtml::image($model->getImageUrl(), $model->title); ?>
            <?php endif; ?>
            <p> <?= $model->full_text; ?></p>
        </div>
    </div>
</div>
