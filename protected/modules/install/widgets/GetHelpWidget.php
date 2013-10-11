<?php
/**
 * Created by JetBrains PhpStorm.
 * User: aopeykin
 * Date: 16.09.13
 * Time: 15:24
 * To change this template use File | Settings | File Templates.
 */

class GetHelpWidget extends YWidget
{
    public $view = 'gethelpwidget';

    public function run()
    {
        $this->render($this->view);
    }

}