<?php
/**
 * Отображение для Default/_show_images:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
?>
<div id="gallery-wrapper">
    <?php $this->widget('gallery.widgets.GalleryWidget', array('gallery_id' => $model->id, 'gallery' => $model, 'limit' => 30)); ?>
</div>