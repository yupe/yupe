<?php
/**
 * Отображение для gallery/edit-image:
 *
 * @category YupeView
 * @package  YupeCMS
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
$this->title = [Yii::t('GalleryModule.gallery', 'Gallery'), Yii::app()->getModule('yupe')->siteName];
$this->breadcrumbs = [
    Yii::t('GalleryModule.gallery', 'Galleries') => ['/gallery/gallery/index'],
    $model->gallery->name                        => $model->gallery->getUrl(),
    Yii::t(
        'GalleryModule.gallery',
        'Edit message #{id}',
        [
            '{id}' => $model->id
        ]
    )
]; ?>
<h1 class="page-header">
    <?= Yii::t(
        'GalleryModule.gallery',
        'Edit message #{id}',
        ['{id}' => $model->id]
    ); ?>
</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>
