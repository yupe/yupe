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
            'name' => $product->slug,
        ];

        if (isset($product->category)) {
            $params['category'] = $product->category->path;
        }

        return $absolute ? Yii::app()->createAbsoluteUrl($route, $params) : Yii::app()->createUrl($route, $params);
    }
}