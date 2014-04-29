<?php
/**
 * Отображение для ./themes/default/views/news/news/news.php:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
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
        <div class="span8">
            <h4><strong><?php echo CHtml::encode($news->title);?></strong></h4>
        </div>
    </div>
    <div class="row">
        <div class="span8">
            <p> <?php echo $news->full_text; ?></p>
        </div>
    </div>
</div>

<?php $this->widget('application.modules.comment.widgets.CommentsListWidget', array('model' => $news, 'modelId' => $news->id)); ?>
    <br/>
    <h3>Оставить комментарий</h3>
<?php $this->widget('application.modules.comment.widgets.CommentFormWidget', array('redirectTo' => $news->getPermaLink(), 'model' => $news, 'modelId' => $news->id, 'allowGuestComment'=>true)); ?>