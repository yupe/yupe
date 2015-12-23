<?php

class StoreCategoryRepository extends CApplicationComponent
{
    /**
     * @param $slug
     *
     * @return array|mixed|null
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
}