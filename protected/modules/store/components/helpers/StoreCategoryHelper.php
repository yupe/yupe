<?php

class StoreCategoryHelper
{
    const CACHE_CATEGORY_TREE = 'Store::StoreCategory::CategoryTree';
    const CACHE_CATEGORY_LIST = 'Store::StoreCategory::CategoryList';
    const CACHE_CATEGORY_TAG = 'yupe::store::categories';

    /**
     * Get store categories tree
     *
     * @return array
     */
    public static function tree()
    {
        $tree = Yii::app()->getCache()->get(self::CACHE_CATEGORY_TREE);

        return $tree ?: self::generateTree();
    }

    /**
     * Get store categories formatted list (id => name)
     *
     * @param string $prefix
     *
     * @return array
     */
    public static function formattedList($prefix = '&emsp;')
    {
        $formattedList = Yii::app()->getCache()->get(self::CACHE_CATEGORY_LIST);

        if ($formattedList) {
            return $formattedList;
        }

        $formattedList = [];

        $flatten = function ($tree, $level = 0) use (&$flatten, &$formattedList, $prefix) {
            foreach ($tree as $item) {
                $formattedList[$item['id']] = str_repeat($prefix, $level) . $item['name'];
                if (isset($item['items'])) {
                    $flatten($item['items'], $level + 1);
                }
            }
        };

        $flatten(self::tree());

        Yii::app()->getCache()->set(self::CACHE_CATEGORY_LIST, $formattedList, 0, new TagsCache(self::CACHE_CATEGORY_TAG));

        return $formattedList;
    }

    /**
     * Generate store category tree
     *
     * @param string $order
     *
     * @return array
     */
    private static function generateTree($order = 'sort')
    {
        $tree = [];
        $data = StoreCategory::model()->findAll(['order' => $order]);

        foreach ($data as $item) {
            $tree[$item->id] = [
                'id' => $item->id,
                'parent_id' => $item->parent_id,
                'name' => $item->name,
                'status' => $item->status,
            ];
        }

        foreach ($tree as $key => &$value) {
            if (isset($tree[$value['parent_id']])) {
                $tree[$value['parent_id']]['items'][$key] = &$value;
            }
            unset($value);
        }

        $tree = array_filter($tree, function ($value) {
            return $value['parent_id'] == 0;
        });

        Yii::app()->getCache()->set(self::CACHE_CATEGORY_TREE, $tree, 0, new TagsCache(self::CACHE_CATEGORY_TAG));

        return $tree;
    }
}