<?php
/**
 * Created by JetBrains PhpStorm.
 * User: andrey
 * Date: 9/6/13
 * Time: 7:14 PM
 * To change this template use File | Settings | File Templates.
 */

class PostMetaWidget extends YWidget
{
    public $post;

    public function run()
    {
        $this->render('post-meta',array('post' => $this->post));
    }
}