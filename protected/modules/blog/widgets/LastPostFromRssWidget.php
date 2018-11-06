<?php
/**
 * Виджет для отображения записей из RSS ленты
 *
 * @author Oleg Filimonov <olegsabian@gmail.com>
 * @link https://yupe.ru
 * @copyright 2009-2016 amyLabs && Yupe! team
 * @package yupe.modules.blog.widgets
 */

use yupe\widgets\YWidget;

class LastPostFromRssWidget extends YWidget
{
    public $url = null;

    public $limit = 5;

    public $view = 'default';

    public function run()
    {
        if (is_null($this->url) || !$this->checkUrlStatus()) {
            return false;
        }

        $data = $this->getFeedData();

        if ($data) {
            $this->render($this->view, [
                'data' => $data,
                'limit' => $this->limit,
            ]);
        }

        return true;
    }

    /**
     * Check url status code
     *
     * @return bool
     */
    private function checkUrlStatus()
    {
        $request = curl_init($this->url);

        curl_setopt($request, CURLOPT_HEADER, true);
        curl_setopt($request, CURLOPT_NOBODY, true);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($request, CURLOPT_TIMEOUT, 10);

        curl_exec($request);
        $httpCode = curl_getinfo($request, CURLINFO_HTTP_CODE);
        curl_close($request);

        if ($httpCode >= 200 && $httpCode < 400) {
            return true;
        }

        return false;
    }

    /**
     * Get feed data
     *
     * @return bool|SimpleXMLElement
     */
    private function getFeedData()
    {
        libxml_use_internal_errors(true);

        $hash = md5($this->url);
        $feed = Yii::app()->cache->get("LastPostFromRss::url::{$hash}");

        if ($feed === false) {
            $request = curl_init($this->url);

            curl_setopt($request, CURLOPT_HEADER, 0);
            curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);

            $feed = curl_exec($request);

            curl_close($request);
        }

        $data = simplexml_load_string($feed);

        if (count(libxml_get_errors()) > 0) {
            return false;
        }

        Yii::app()->cache->set(
            "LastPostFromRss::url::{$hash}",
            $feed,
            $this->cacheTime,
            new TagsCache('last.post.from.rss', $hash)
        );

        return $data;
    }
}