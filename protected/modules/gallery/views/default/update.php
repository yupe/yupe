<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('gallery')->getCategory() => array(),
        Yii::t('GalleryModule.gallery', 'Галереи') => array('/gallery/default/index'),
        $model->name => array('/gallery/default/view', 'id' => $model->id),
        Yii::t('GalleryModule.gallery', 'Редактирование'),
    );

    $this->pageTitle = Yii::t('GalleryModule.gallery', 'Галереи - редактирование');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('GalleryModule.gallery', 'Список галарей'), 'url' => array('/gallery/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('GalleryModule.gallery', 'Добавить галерею'), 'url' => array('/gallery/default/create')),
        array('label' => Yii::t('GalleryModule.gallery', 'Галерея') . ' «' . mb_substr($model->name, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('GalleryModule.gallery', 'Редактирование галереи'), 'url' => array(
            '/gallery/default/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('GalleryModule.gallery', 'Просмотреть галерею'), 'url' => array(
            '/gallery/default/view',
            'id' => $model->id
        )),
        array('icon' => 'picture', 'label' => Yii::t('GalleryModule.gallery', 'Изображения галереи'), 'url' => array('/gallery/default/images', 'id' => $model->id)),
        array('icon' => 'trash', 'label' => Yii::t('GalleryModule.gallery', 'Удалить галерею'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/gallery/default/delete', 'id' => $model->id),
            'params' => array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken),
            'confirm' => Yii::t('GalleryModule.gallery', 'Вы уверены, что хотите удалить галерею?'),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('GalleryModule.gallery', 'Редактирование галереи'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
