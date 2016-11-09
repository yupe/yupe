<?php

/**
 * Class UserCommentsWidget
 */
class UserCommentsWidget extends yupe\widgets\YWidget
{
    /**
     * @var
     */
    public $userId;

    /**
     * @var string
     */
    public $view = 'usercommentswidget';

    /**
     * @var
     */
    public $label;

    /**
     * @throws CException
     */
    public function init()
    {
        if (!$this->userId) {
            throw new CException('Error "UserCommentsWidget::userId" is not set!');
        }

        parent::init();
    }

    /**
     * @throws CException
     */
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
