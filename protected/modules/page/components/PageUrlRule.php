<?php

/**
 * Class PageUrlRule
 */
class PageUrlRule extends CBaseUrlRule
{
    const CACHE_KEY = 'page::slugs';

    /**
     * @param CUrlManager $manager
     * @param string $route
     * @param array $params
     * @param string $amp
     * @return bool
     */
    public function createUrl($manager, $route, $params, $amp)
    {
        if ($route === 'page/page/view' && isset($params['slug'])) {
            return $params['slug'];
        }

        return false;
    }

    /**
     * @param \yupe\components\urlManager\LangUrlManager $manager
     * @param CHttpRequest $request
     * @param string $pathInfo
     * @param string $rawPathInfo
     * @return bool|string
     */
    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {
        $slugs = Yii::app()->getCache()->get(self::CACHE_KEY);

        if (false === $slugs) {

            $slugs = Yii::app()->getDb()->createCommand()
                ->setFetchMode(PDO::FETCH_COLUMN, 0)
                ->from('{{page_page}}')
                ->select('slug')
                ->queryAll();

            Yii::app()->getCache()->set(self::CACHE_KEY, $slugs, 0);
        }

        $slug = $manager->removeLangFromUrl($pathInfo);

        if (in_array($slug, $slugs, true)) {
            return 'page/page/view/slug/' . $slug;
        }

        return false;
    }
}