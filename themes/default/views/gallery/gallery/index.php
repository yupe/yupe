<?php
/**
 * Отображение для gallery/list:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 *
 * @var $this GalleryController
 * @var $dataProvider CActiveDataProvider
 **/

$this->title = [Yii::t('GalleryModule.gallery', 'Image galleries'), Yii::app()->getModule('yupe')->siteName];
$this->breadcrumbs = [Yii::t('GalleryModule.gallery', 'Image galleries')];

?>
<div class="gallery-list">

    <h1 class="page-header">
        <?= Yii::t('GalleryModule.gallery', 'Image galleries'); ?>
    </h1>

    <?php
    $this->widget(
        'bootstrap.widgets.TbListView',
        [
            'dataProvider' => $dataProvider,
            'itemView'     => '_item',
            'template'     => "{items}\n{pager}",
            'separator'    => '<hr>',
        ]
    ); ?>
</div>
