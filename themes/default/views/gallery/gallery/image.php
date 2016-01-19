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

$this->title = $model->name; ?>
<?php $this->breadcrumbs = [
    Yii::t('GalleryModule.gallery', 'Galleries') => ['/gallery/gallery/index'],
    $model->gallery->name => ['/gallery/gallery/view', 'id' => $model->gallery->id],
    $model->name
];
?>
<h1 class="page-header"><?= CHtml::encode($model->name); ?></h1>
<div class="thumbnail">
    <?= CHtml::image($model->getImageUrl(), $model->name); ?>
</div>
<hr>
<p>
    <?= CHtml::image($model->user->getAvatar(16), $model->user->nick_name); ?> <?= CHtml::link(
        $model->user->nick_name,
        ['/user/people/userInfo', 'username' => $model->user->nick_name]
    ); ?>
    <i class="fa fa-calendar"></i> <?= Yii::app()->getDateFormatter()->format(
        'dd MMMM yyyy г., hh:mm',
        $model->create_time
    ); ?>
</p>

<blockquote>
    <p><?= CHtml::encode($model->description); ?></p>
</blockquote>

<?php
$this->widget('application.modules.comment.widgets.CommentsWidget', [
    'redirectTo' => Yii::app()->createUrl('/gallery/gallery/view', ['id' => $model->gallery->id]),
    'model' => $model,
]);
