<?php
Yii::import('booster.widgets.TbMenu');

/**
 * Class YMenu
 */
class YMenu extends TbMenu
{
    /**
     * @param array $item
     * @param string $route
     * @return bool
     */
    public function isItemActive($item, $route)
    {
        return parent::isItemActive($item, $route) || (isset($item['url']) && is_string($item['url']) ? strcasecmp(
                $item['url'],
                Yii::app()->getRequest()->requestUri
            ) == 0 : false);
    }
}
