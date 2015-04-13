<?php
/**
 * Отображение для gallery/image:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 *
 * @var $this GalleryController
 * @var $model Image
 **/

$this->title = [$model->name, Yii::app()->getModule('yupe')->siteName]; ?>
<?php $this->breadcrumbs = [
    Yii::t('GalleryModule.gallery', 'Galleries') => ['/gallery/gallery/list'],
    $model->gallery->name => $model->gallery->getUrl(),
    $model->name
];
?>
<h1 class="page-header"><?php echo CHtml::encode($model->name); ?></h1>
<div class="thumbnail">
    <?php echo CHtml::image($model->getImageUrl(), $model->name); ?>
</div>
<hr>
<p>
    <?php echo CHtml::image($model->user->getAvatar(16), $model->user->nick_name); ?> <?php echo CHtml::link(
        $model->user->nick_name,
        ['/user/people/userInfo', 'username' => $model->user->nick_name]
    ); ?>
    <i class="fa fa-calendar"></i> <?php echo Yii::app()->getDateFormatter()->format(
        'dd MMMM yyyy г., hh:mm',
        $model->creation_date
    ); ?>
</p>

<blockquote>
    <p><?php echo CHtml::encode($model->description); ?></p>
</blockquote>

<?php $this->widget(
    'application.modules.comment.widgets.CommentsListWidget',
    ['model' => $model, 'modelId' => $model->id]
); ?>

<?php $this->widget(
    'application.modules.comment.widgets.CommentFormWidget',
    [
        'redirectTo' => $model->gallery->getUrl(),
        'model'      => $model,
        'modelId'    => $model->id
    ]
); ?>
