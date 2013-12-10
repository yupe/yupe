<?php
/**
 * Отображение для Default/images:
 * 
 *   @category YupeView
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$this->pageTitle = 'Галерея - Изображения галереи';

$this->breadcrumbs = array(    
    Yii::t('GalleryModule.gallery', 'Galleries') => array('/gallery/galleryBackend/index'),
    $model->name,
);

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('GalleryModule.gallery', 'Galleries list'), 'url' => array('/gallery/galleryBackend/index')),
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
); ?>

<div class="page-header">
    <h1>
        <?php echo Yii::t('GalleryModule.gallery', 'Show gallery'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php
$this->widget(
    'bootstrap.widgets.TbTabs', array(
        'type'=>'tabs', // 'tabs' or 'pills'
        'tabs'=>array(
            array(
                'id'      => '_images_show',
                'label'   => Yii::t('GalleryModule.gallery','Show gallery'),
                'content' => $this->renderPartial(
                    '_images_show', array(
                        'model' => $model,
                        'dataProvider' => $dataProvider
                    ), true
                ),
                'active'  => $tab == '_images_show',
            ),
            array(
                'id'      => '_image_add',
                'label'   => Yii::t('GalleryModule.gallery','Create image'),
                'content' => $this->renderPartial(
                    '_image_add', array(
                        'model'   => $image,
                    ), true
                ),
                'active'  => $tab == '_image_add',
            ),
            array(
                'id'      => '_images_add',
                'label'   => Yii::t('GalleryModule.gallery','Group adding'),
                'content' => $this->renderPartial(
                    '_images_add', array(
                        'model'   => $image,
                        'gallery' => $model,
                    ), true
                ),
                'active'  => $tab == '_images_add',
            ),
        ),
        'events'=>array('shown'=>'js:loadContent')
    )
); ?>
<script>
var loadContent;
var loadedCount = 0;
jQuery(document).ready(function($) {
    loadContent = function(e) {
        $.fn.yiiListView.update('gallery');
    }
});
</script>
