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
    Yii::t('GalleryModule.gallery', 'Galleries') => ['/gallery/gallery/index'],
    $model->gallery->name => $model->gallery->getUrl(),
    $model->name
];
?>
<div class="main__title grid">
    <h1 class="h2"><?= CHtml::encode($model->name); ?></h1>
</div>
<div class="main__catalog grid">
    <div class="cols">
        <div class="col grid-module-9">
            <?= CHtml::image($model->getImageUrl(), $model->name); ?>
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

            <div class="fast-order__inputs">
                <?php
                $this->widget('application.modules.comment.widgets.CommentsWidget', [
                    'redirectTo' => $model->gallery->getUrl(),
                    'model' => $model,
                ]); ?>
            </div>
        </div>
    </div>
</div>