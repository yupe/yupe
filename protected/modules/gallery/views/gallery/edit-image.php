<?php
/**
 * Отображение для gallery/edit-image:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
$this->pageTitle = 'Галерея';
$this->breadcrumbs = [
    Yii::t('GalleryModule.gallery', 'Galleries') => ['/gallery/gallery/list'],
    $model->gallery->name                        => ['/gallery/gallery/show', 'id' => $model->gallery->id],
    Yii::t(
        'GalleryModule.gallery',
        'Edit image #{id}',
        [
            '{id}' => $model->id
        ]
    )
]; ?>
<h1 class="page-header">
    <?php echo Yii::t(
        'GalleryModule.gallery',
        'Edit image #{id}',
        ['{id}' => $model->id]
    ); ?>
</h1>

<?php $this->renderPartial('_form', ['model' => $model]); ?>
