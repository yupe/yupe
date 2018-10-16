<?php

/**
 * Class UserBlogsWidget
 */
class UserBlogsWidget extends yupe\widgets\YWidget
{
    /**
     * @var string
     */
    public $view = 'userblogs';

    /**
     * @var
     */
    public $userId;

    /**
     * @throws CException
     */
    public function init()
    {
        if (!$this->userId) {
            throw new CException(Yii::t('BlogModule.blog', 'UserBlogsWidget.userId is not defined =('));
        }

        parent::init();
    }

    /**
     * @throws CException
     */
    public function run()
    {
        $this->render($this->view, ['models' => Blog::model()->getMembershipListForUser($this->userId)]);
    }
}
