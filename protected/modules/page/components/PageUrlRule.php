<?php

/**
 * Class PageUrlRule
 */
class PageUrlRule extends CBaseUrlRule
{
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
        $parts = explode('/', $manager->removeLangFromUrl($pathInfo));

        if (!empty($parts)) {
            $page = Page::model()->published()->findBySlug($parts[0]);
            return null === $page ? false : 'page/page/view/slug/' . $page->slug;
        }

        return false;
    }
}