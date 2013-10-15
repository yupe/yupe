<?php
/**
 * Отображение для Default/view:
 * 
 *   @category YupeView
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
    $this->breadcrumbs = array(
        Yii::app()->getModule('gallery')->getCategory() => array(),
        Yii::t('GalleryModule.gallery', 'Galleries') => array('/gallery/galleryBackend/index'),
        $model->name,
    );

    $this->pageTitle = Yii::t('GalleryModule.gallery', 'Galleries - show');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('GalleryModule.gallery', 'Galleries list'), 'url' => array('/gallery/galleryBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('GalleryModule.gallery', 'Create gallery'), 'url' => array('/gallery/galleryBackend/create')),
        array('label' => Yii::t('GalleryModule.gallery', 'Gallery') . ' «' . mb_substr($model->name, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('GalleryModule.gallery', 'Edit gallery'), 'url' => array(
            '/gallery/galleryBackend/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('GalleryModule.gallery', 'View gallery'), 'url' => array(
            '/gallery/galleryBackend/view',
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
        <?php echo Yii::t('GalleryModule.gallery', 'Show gallery'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php
$this->widget(
    'bootstrap.widgets.TbDetailView', array(
        'data'       => $model,
        'attributes' => array(
            'id',
            'name',
            array(
                'name' => 'description',
                'type' => 'html'
            ),
            array(
                'name'  => 'status',
                'value' => $model->getStatus()
            ),
        ),
    )
); ?>
