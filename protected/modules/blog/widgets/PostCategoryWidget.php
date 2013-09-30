<?php

/**
 * PostCategoryWidget виджет для вывода категорий постов
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.blog.widgets
 * @since 0.1
 *
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