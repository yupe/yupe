<?php
/**
 * Created by JetBrains PhpStorm.
 * User: aopeykin
 * Date: 03.06.13
 * Time: 12:10
 * To change this template use File | Settings | File Templates.
 */

class PostCategoryWidget extends YWidget
{
    public function run()
    {
        $data = Yii::app()->db->cache($this->cacheTime)->createCommand()
            ->select('c.id, c.name, c.alias , count(p.id) postCnt')
            ->from('{{blog_post}} p')
            ->join('{{category_category}} c','p.category_id = c.id')
            ->order('postCnt DESC')
            ->group('c.id')->queryAll();


        $this->render('post-category',array('data' => $data));
    }
}