<?php
    $this->breadcrumbs = array(       
        Yii::t('GalleryModule.gallery', 'Galleries') => array('/gallery/galleryBackend/index'),
        $model->name => array('/gallery/galleryBackend/view', 'id' => $model->id),
        Yii::t('GalleryModule.gallery', 'Edit'),
    );

    $this->pageTitle = Yii::t('GalleryModule.gallery', 'Galleries - edit');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('GalleryModule.gallery', 'Gallery management'), 'url' => array('/gallery/galleryBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('GalleryModule.gallery', 'Create gallery'), 'url' => array('/gallery/galleryBackend/create')),
        array('label' => Yii::t('GalleryModule.gallery', 'Gallery') . ' «' . mb_substr($model->name, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('GalleryModule.gallery', 'Edit gallery'), 'url' => array(
            '/gallery/galleryBackend/update',
            'id' => $model->id
        )),
        array('icon' => 'picture', 'label' => Yii::t('GalleryModule.gallery', 'Gallery images'), 'url' => array('/gallery/galleryBackend/images', 'id' => $model->id)),
        array('icon' => 'trash', 'label' => Yii::t('GalleryModule.gallery', 'Remove gallery'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/gallery/galleryBackend/delete', 'id' => $model->id),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t('GalleryModule.gallery', 'Do you really want to remove gallery?'),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('GalleryModule.gallery', 'Edit gallery'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
