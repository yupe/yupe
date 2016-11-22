<?php

/**
 * Class StoreCategoryRepository
 */
class StoreCategoryRepository extends CApplicationComponent
{

    /**
     * @param $slug
     * @return static
     */
    public function getByAlias($slug)
    {
        return StoreCategory::model()->published()->find(
            'slug = :slug',
            [
                ':slug' => $slug,
            ]
        );
    }

    /**
     *
     */
    public function getAllDataProvider()
    {
        new CArrayDataProvider(
            StoreCategory::model()->published()->getMenuList(1), [
                'id' => 'id',
                'pagination' => false,
            ]
        );
    }

    /**
     * @param $path
     * @return mixed
     */
    public function getByPath($path)
    {
        return StoreCategory::model()->published()->findByPath($path);
    }
}