<?php

/**
 * Class SiteMapBeforeGenerateEvent
 */
class SiteMapBeforeGenerateEvent extends \yupe\components\Event
{
    /**
     * @var
     */
    protected $generator;

    /**
     * @return mixed
     */
    public function getGenerator()
    {
        return $this->generator;
    }

    /**
     * @param SitemapGenerator $generator
     */
    public function __construct(SitemapGenerator $generator)
    {
        $this->generator = $generator;
    }
} 
