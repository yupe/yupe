<?php
class CategoryRepository extends CApplicationComponent
{
    private $cache;
    private $cacheTime;

    public function init()
    {
        $this->cache = Yii::app()->getCache();
        $this->cacheTime = Yii::app()->getModule('category')->coreCacheTime;

        return parent::init();
    }

    /**
     * Returns descendants of the parent category
     *
     * @param int $parent
     * @return array
     */
    public function getDescendants($parent)
    {
        $cacheName = CategoryHelper::CATEGORY_CACHE_DESCENDANTS . $parent;

        $descendants = $this->cache->get($cacheName);

        if ($descendants === false) {
            $descendants = $this->generateDescendants($parent);

            $this->cache->set($cacheName, $descendants, $this->cacheTime, new TagsCache(CategoryHelper::CATEGORY_CACHE_TAG));
        }

        return $descendants;
    }

    /**
     * Generates descendants list
     *
     * @param int $parent Parent category id
     * @return array
     */
    private function generateDescendants($parent)
    {
        $out = [];

        $categories = Category::model()->findAll('parent_id = :id', [':id' => $parent]);

        foreach ($categories as $category) {
            $out[] = $category;
            $out = CMap::mergeArray($out, $this->generateDescendants((int)$category->id));
        }

        return $out;
    }

    /**
     * Returns formatted category tree
     *
     * @param null|int $parentId
     * @param int $level
     * @param null|array|CDbCriteria $criteria
     * @param string $spacer
     * @return array
     */
    public function getFormattedList($parentId = null, $level = 0, $criteria = null, $spacer = '&emsp;')
    {
        if (empty($parentId)) {
            $parentId = null;
        }

        $categories = Category::model()->findAllByAttributes(['parent_id' => $parentId], $criteria);

        $list = [];

        foreach ($categories as $category) {

            $category->name = str_repeat($spacer, $level) . $category->name;

            $list[$category->id] = $category->name;

            $list = CMap::mergeArray($list, $this->getFormattedList($category->id, $level + 1, $criteria));
        }

        return $list;
    }

    /**
     * Returns category by alias
     *
     * @param $slug
     * @return mixed
     */
    public function getByAlias($slug)
    {
        $cacheName = CategoryHelper::CATEGORY_CACHE_ALIAS . $slug;

        $category = $this->cache->get($cacheName);

        if ($category === false) {
            $category = Category::model()->published()->find('slug = :slug', [':slug' => $slug]);

            $this->cache->set($cacheName, $category, $this->cacheTime, new TagsCache(CategoryHelper::CATEGORY_CACHE_TAG));
        }

        return $category;
    }

    /**
     * Returns published category by id
     *
     * @param int $id
     * @return Category
     */
    public function getById($id)
    {
        return Category::model()->published()->findByPk($id);
    }
}