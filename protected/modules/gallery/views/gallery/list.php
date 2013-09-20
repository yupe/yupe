<?php
/**
 * Отображение для gallery/list:
 *
 * @category YupeView
 * @package  YupeCMS
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
?>
<div class="gallery-list">
<?php $this->pageTitle = Yii::t('GalleryModule.gallery', 'Image galleries'); ?>
<?php $this->breadcrumbs = array(Yii::t('GalleryModule.gallery', 'Image galleries'));?>

<h1 class="page-header">
    <?php echo Yii::t('GalleryModule.gallery', 'Image galleries'); ?>
</h1>

<?php
$this->widget(
    'bootstrap.widgets.TbListView', array(
        'dataProvider' => $dataProvider,
        'itemView' => '_view',
        'template' => "{items}\n{pager}",
        'separator' => '<hr>',
    )
); ?>
</div>

