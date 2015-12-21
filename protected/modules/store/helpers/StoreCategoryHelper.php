<?php

class StoreCategoryHelper
{
    const CACHE_CATEGORY_TREE = 'Store::StoreCategory::CategoryTree';
    const CACHE_CATEGORY_LIST = 'Store::StoreCategory::CategoryList';

    /**
     * Get store categories tree
     *
     * @return array
     */
    public static function tree()
    {
        $tree = Yii::app()->getCache()->get(self::CACHE_CATEGORY_TREE);

        if ($tree) {
            return $tree[0];
        }

        $tree = [];
        $data = StoreCategory::model()->findAll(['order' => 'sort']);

        $generate_tree = function (&$branch) use (&$generate_tree, &$tree) {
            foreach ($branch as &$item) {
                if (!isset($tree[$item['id']])) {
                    $item['items'] = [];
                    continue;
                }

                $item['items'] = $tree[$item['id']];
                unset($tree[$item['id']]);

                $generate_tree($item['items']);
            }
        };

        foreach ($data as $item) {
            $tree[$item->parent_id ?: 0][] = [
                'id' => $item->id,
                'name' => $item->name,
            ];
        }

        foreach ($tree as $key => &$branch) {
            if ($key > 0) {
                continue;
            }
            $generate_tree($branch);
        }

        Yii::app()->getCache()->set(self::CACHE_CATEGORY_TREE, $tree);

        return $tree[0];
    }

    /**
     * Get store categories formatted list (id => name)
     *
     * @return array
     */
    public static function formattedList()
    {
        $formattedList = Yii::app()->getCache()->get(self::CACHE_CATEGORY_LIST);

        if ($formattedList) {
            return $formattedList;
        }

        $formattedList = [];

        $flatten = function ($tree, $level = 0) use (&$flatten, &$formattedList) {
            foreach ($tree as $item) {
                $formattedList[$item['id']] = str_repeat('&emsp;', $level) . $item['name'];
                if (count($item['items'])) {
                    $flatten($item['items'], $level + 1);
                }
            }
        };

        $flatten(self::tree());

        Yii::app()->getCache()->set(self::CACHE_CATEGORY_LIST, $formattedList);

        return $formattedList;
    }
}