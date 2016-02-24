<?php

class ProductHelper
{
    /**
     * Get product url
     *
     * @param Product $product
     * @param bool $absolute
     * @return string
     */
    public static function getUrl(Product $product, $absolute = false)
    {
        $route = '/store/product/view';
        $params = [
            'category' => $product->category->path,
            'name' => $product->slug,
        ];

        return $absolute ? Yii::app()->createAbsoluteUrl($route, $params) : Yii::app()->createUrl($route, $params);
    }
}