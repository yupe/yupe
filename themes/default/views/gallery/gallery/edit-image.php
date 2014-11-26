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
$this->pageTitle = Yii::t('GalleryModule.gallery', 'Gallery');
$this->breadcrumbs = [
    Yii::t('GalleryModule.gallery', 'Galleries') => ['/gallery/gallery/list'],
    $model->gallery->name                        => ['/gallery/gallery/show', 'id' => $model->gallery->id],
    Yii::t(
        'GalleryModule.gallery',
        'Edit message #{id}',
        [
            '{id}' => $model->id
        ]
    )
]; ?>
<h1 class="page-header">
    <?php echo Yii::t(
        'GalleryModule.gallery',
        'Edit message #{id}',
        ['{id}' => $model->id]
    ); ?>
</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>
