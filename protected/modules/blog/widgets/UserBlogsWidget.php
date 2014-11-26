<?php

class UserBlogsWidget extends yupe\widgets\YWidget
{
    public $view = 'userblogs';

    public $userId;

    public function init()
    {
        if (!$this->userId) {
            throw new CException(Yii::t('BlogModule.blog', 'UserBlogsWidget.userId is not defined =('));
        }

        parent::init();
    }

    public function run()
    {
        $this->render($this->view, ['models' => Blog::model()->getMembershipListForUser($this->userId)]);
    }
}
