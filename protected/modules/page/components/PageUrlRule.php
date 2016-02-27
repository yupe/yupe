<?php

class PageUrlRule extends CBaseUrlRule
{
    public function createUrl($manager, $route, $params, $amp)
    {
        if ($route === 'page/page/view' && isset($params['slug'])) {
            return $params['slug'];
        }

        return false;
    }

    public function parseUrl($manager, $route, $params, $amp)
    {
        return false;
    }
}