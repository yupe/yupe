<?php

class PanelStatWidget extends \yupe\widgets\YWidget
{
    public function run()
    {
        $dataProvider = new CActiveDataProvider('Post', array(
            'sort' => array(
                'defaultOrder' => 'id DESC',
            ),
            'pagination'=>array(
                'pageSize'=> (int)$this->limit,
            ),
        ));

        $cacheTime = Yii::app()->controller->yupe->coreCacheTime;

        $this->render('panel-stat', array(
                'postsCount'    => Post::model()->cache($cacheTime)->count('create_date >= :time', array(':time' => time() - 24 * 60 * 60)),
                'commentCount'  => Comment::model()->cache($cacheTime)->count('creation_date >= (CURDATE() - INTERVAL 1 DAY)'),
                'allPostsCnt'   => Post::model()->cache($cacheTime)->count(),
                'allCommentCnt' => Comment::model()->cache($cacheTime)->count(),
                'dataProvider' => $dataProvider
            ));
    }
} 