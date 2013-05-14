<?php
/**
 * Отображение для Default/images:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$this->pageTitle = 'Галерея - Изображения галереи';

$this->breadcrumbs = array(
    Yii::app()->getModule('gallery')->getCategory() => array(),
    Yii::t('GalleryModule.gallery', 'Галереи') => array('/gallery/default/index'),
    $model->name,
);

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
); ?>

<div class="page-header">
    <h1>
        <?php echo Yii::t('GalleryModule.gallery', 'Просмотр галереи'); ?><br />
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
                'label'   => 'Просмотр галереи',
                'content' => $this->renderPartial(
                    '_images_show', array(
                        'model' => $model,
                    ), true
                ),
                'active'  => $tab == '_images_show',
            ),
            array(
                'id'      => '_image_add',
                'label'   => 'Добавить изображение',
                'content' => $this->renderPartial(
                    '_image_add', array(
                        'model'   => $image,
                    ), true
                ),
                'active'  => $tab == '_image_add',
            ),
            array(
                'id'      => '_images_add',
                'label'   => 'Групповое добавление',
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
