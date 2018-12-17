<?php
/**
 * Отображение для Default/_show_images:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     https://yupe.ru
 **/
$mainAssets = Yii::app()->assetManager->publish(Yii::getPathOfAlias('gallery.views.assets'));
Yii::app()->getClientScript()->registerCssFile($mainAssets . '/css/gallery.css');
Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/js/gallery-sortable.js', CClientScript::POS_END);

$this->widget('gallery.extensions.colorbox.ColorBox', [
    'target' => '.gallery-image',
    'config' => [ // тут конфиги плагина, подробнее http://www.jacklmoore.com/colorbox
    ],
]);
$keys = [];
?>

<div id="gallery-wrapper">
    <div class="row gallery-thumbnails thumbnails">
        <?php
            foreach($dataProvider as $data) {
                $keys[] = sprintf('<span data-order="%d">%d</span>', $data->position, $data->id);
                $this->renderPartial('_image', [
                    'gallery' => $model,
                    'data' => $data,
                ]);
            }
        ?>
    </div>
</div>

<div class="sortOrder hidden"
    data-token-name="<?= Yii::app()->getRequest()->csrfTokenName; ?>"
    data-token="<?= Yii::app()->getRequest()->getCsrfToken(); ?>"
    data-action="<?= Yii::app()->createUrl('/gallery/galleryBackend/sortable') ?>"
    >
    <?= implode('', $keys) ?>
</div>
