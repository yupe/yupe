<?php
class UserCommentsWidget extends yupe\widgets\YWidget
{
    public $userId;

    public $view = 'usercommentswidget';

    public function init()
    {
        if(!$this->userId) {
            throw new CException('Error "UserCommentsWidget::userId" is not set!');
        }

        parent::init();
    }

    public function run()
    {
        $comments = Comment::model()->findAll(array(
            'condition' => 'user_id = :user AND t.status = :status AND t.id != t.root',
            'params' => array(
                ':user' => (int)$this->userId,
                ':status' => Comment::STATUS_APPROVED
            ),
            'order' => 't.lft, t.id DESC',
        ));

        $this->render($this->view, array('comments' => $comments));
    }
} 