<?php
namespace yupe\components\controllers;

/**
 * Class RssController
 * @package yupe\components\controllers
 */
abstract class RssController extends FrontController
{
    /**
     * @var
     */
    public $title;

    /**
     * @var
     */
    public $description;

    /**
     * @var
     */
    public $data;

    /**
     * @return mixed
     */
    abstract public function loadData();

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->loadData();
    }
}
