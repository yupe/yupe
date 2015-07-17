<?php

/**
 * Class SitemapHelper
 */
class SitemapHelper
{
    /**
     *
     */
    const FREQUENCY_ALWAYS = 'always';
    /**
     *
     */
    const FREQUENCY_HOURLY = 'hourly';
    /**
     *
     */
    const FREQUENCY_DAILY = 'daily';
    /**
     *
     */
    const FREQUENCY_WEEKLY = 'weekly';
    /**
     *
     */
    const FREQUENCY_MONTHLY = 'monthly';
    /**
     *
     */
    const FREQUENCY_YEARLY = 'yearly';
    /**
     *
     */
    const FREQUENCY_NEVER = 'never';

    /**
     * @param $date
     * @return bool|string
     */
    public static function dateToW3C($date)
    {
        if (is_int($date)) {
            return date(DATE_W3C, $date);
        } else {
            return date(DATE_W3C, strtotime($date));
        }
    }

    /**
     * @return array
     */
    public static function getChangeFreqList()
    {
        return [
            self::FREQUENCY_ALWAYS => Yii::t('SitemapModule.sitemap', 'always'),
            self::FREQUENCY_DAILY => Yii::t('SitemapModule.sitemap', 'daily'),
            self::FREQUENCY_HOURLY => Yii::t('SitemapModule.sitemap', 'hourly'),
            self::FREQUENCY_MONTHLY => Yii::t('SitemapModule.sitemap', 'monthly'),
            self::FREQUENCY_NEVER => Yii::t('SitemapModule.sitemap', 'never'),
            self::FREQUENCY_WEEKLY => Yii::t('SitemapModule.sitemap', 'weekly'),
            self::FREQUENCY_YEARLY => Yii::t('SitemapModule.sitemap', 'yearly'),
        ];
    }
}
