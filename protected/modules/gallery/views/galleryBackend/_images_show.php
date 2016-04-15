<?php
/**
 * Отображение для Default/_show_images:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
?>
<div id="gallery-wrapper">
    <?php $this->renderPartial(
        'gallerywidget-backend',
        ['gallery' => $model, 'model' => $model, 'dataProvider' => $dataProvider]
    ); ?>
</div>
