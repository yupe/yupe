<?php
class UserBlogsWidget extends yupe\widgets\YWidget
{
	public $view = 'userblogs';

	public $userId;

	public function init()
	{
		if(!$this->userId) {
            throw new CException(Yii::t('BlogModule.blog','userId is not defined =('));              
		}

		parent::init();
	}

	public function run()
	{
        $models = UserToBlog::model()->with('blog')->findAll('user_id = :user_id', array(':user_id' => $this->userId));

        $this->render($this->view, array('models' => $models));
	}
}