<?php
/**
 * Created by PhpStorm.
 * User: aopeykin
 * Date: 21.03.14
 * Time: 16:43
 */

namespace yupe\components\controllers;

abstract class RssController extends FrontController
{
    public $title;

    public $description;

    public $data;

    abstract public function loadData();

    public function init()
    {
        parent::init();

        $this->loadData();
    }
}