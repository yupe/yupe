<?php
/**
 * Отображение для ./themes/default/views/news/news/news.php:
 *
 * @category YupeView
 * @package  YupeCMS
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
?>
<?php $this->pageTitle = $news->title; ?>

<?php
$this->breadcrumbs = array(
    Yii::t('NewsModule.news', 'News') => array('/news/news/index/'),
    CHtml::encode($news->title)
);
?>

<div class="post">
    <div class="row">
        <div class="col-sm-12">
            <h4><strong><?php echo CHtml::encode($news->title); ?></strong></h4>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php if ($news->image): ?>
                <?php echo CHtml::image($news->getImageUrl(), $news->title); ?>
            <?php endif; ?>
            <p> <?php echo $news->full_text; ?></p>
        </div>
    </div>
</div>
