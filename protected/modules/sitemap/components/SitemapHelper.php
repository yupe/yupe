<?php

class SitemapHelper
{
    const ALWAYS  = 'always';
    const HOURLY  = 'hourly';
    const DAILY   = 'daily';
    const WEEKLY  = 'weekly';
    const MONTHLY = 'monthly';
    const YEARLY  = 'yearly';
    const NEVER   = 'never';

    public static function dateToW3C($date)
    {
        if (is_int($date))
        {
            return date(DATE_W3C, $date);
        }
        else
        {
            return date(DATE_W3C, strtotime($date));
        }
    }
}