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
     * @param CUrlManager $manager
     * @param CHttpRequest $route
     * @param string $params
     * @param string $amp
     * @return bool
     */
    public function parseUrl($manager, $route, $params, $amp)
    {
        return false;
    }
}