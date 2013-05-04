<?php
/**
 * Файл отображения для YShortCuts/shortcuts:
 *
 * @category YupeViews
 * @package  YupeCMS
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.1 (dev)
 * @link     http://yupe.ru
 *
 **/
$mainAssets = Yii::app()->assetManager->publish(Yii::getPathOfAlias('application.modules.yupe.views.assets'));
Yii::app()->clientScript->registerCssFile($mainAssets . '/css/shortcuts.css'); ?>
<div class="shortcuts">
<?php
if (count($this->shortcuts) > 0) {
    foreach ($this->shortcuts as $shortcut) {
        if (isset($shortcut['items'])) {
            foreach ($shortcut['items'] as $item) {
                echo CHtml::link(
                    $this->getLabel($item), $item['url'], $this->getHtmlOptions($item)
                );
            }
        } else {
            echo CHtml::link(
                $this->getLabel($shortcut), $shortcut['url'], $this->getHtmlOptions($shortcut)
            );
        }
    }
} ?>
</div>