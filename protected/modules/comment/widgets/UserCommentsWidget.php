<?php

class UserCommentsWidget extends yupe\widgets\YWidget
{
    public $userId;

    public $view = 'usercommentswidget';

    public $label;

    public function init()
    {
        if (!$this->userId) {
            throw new CException('Error "UserCommentsWidget::userId" is not set!');
        }

        parent::init();
    }

    public function run()
    {
        $comments = Comment::model()->findAll(
            [
                'condition' => 'user_id = :user AND t.status = :status AND t.id != t.root',
                'params'    => [
                    ':user'   => (int)$this->userId,
                    ':status' => Comment::STATUS_APPROVED
                ],
                'order'     => 't.id DESC',
                'limit'     => (int)$this->limit
            ]
        );

        $this->render($this->view, ['comments' => $comments, 'label' => $this->label]);
    }
}
