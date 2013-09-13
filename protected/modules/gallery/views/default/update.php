<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('gallery')->getCategory() => array(),
        Yii::t('GalleryModule.gallery', 'Galleries') => array('/gallery/default/index'),
        $model->name => array('/gallery/default/view', 'id' => $model->id),
        Yii::t('GalleryModule.gallery', 'Edit'),
    );

    $this->pageTitle = Yii::t('GalleryModule.gallery', 'Galleries - edit');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('GalleryModule.gallery', 'Galleries list'), 'url' => array('/gallery/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('GalleryModule.gallery', 'Create gallery'), 'url' => array('/gallery/default/create')),
        array('label' => Yii::t('GalleryModule.gallery', 'Gallery') . ' «' . mb_substr($model->name, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('GalleryModule.gallery', 'Edit gallery'), 'url' => array(
            '/gallery/default/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('GalleryModule.gallery', 'View gallery'), 'url' => array(
            '/gallery/default/view',
            'id' => $model->id
        )),
        array('icon' => 'picture', 'label' => Yii::t('GalleryModule.gallery', 'Gallery images'), 'url' => array('/gallery/default/images', 'id' => $model->id)),
        array('icon' => 'trash', 'label' => Yii::t('GalleryModule.gallery', 'Remove gallery'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/gallery/default/delete', 'id' => $model->id),
            'params' => array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken),
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
