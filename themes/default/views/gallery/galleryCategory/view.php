<?php
/**
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     https://yupe.ru
 *
 * @var $this GalleryCategoryController
 * @var $dataProvider CActiveDataProvider
 * @var $category Category
 **/

$this->title = $category->name;
$this->breadcrumbs = [
    Yii::t('GalleryModule.gallery', 'Galleries') => ['/gallery/gallery/index'],
    Yii::t('GalleryModule.gallery', 'Gallery categories') => ['/gallery/galleryCategory/index'],
    $category->name,
];
?>
<div class="gallery-list">

    <h1 class="page-header">
        <?= $this->title; ?>
    </h1>

    <?php
    $this->widget('bootstrap.widgets.TbListView', [
        'dataProvider' => $dataProvider,
        'itemView' => '//gallery/gallery/_item',
        'template' => "{items}\n{pager}",
        'separator' => '<hr>',
    ]); ?>
</div>
