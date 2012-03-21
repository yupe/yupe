<?php
class LastCommentsWidget extends YWidget
{
    public $model;

    public $commentStatus;

    public function init()
    {

        if ( $this-> model )
            $this->model = is_object($this->model) ? get_class($this->model)
                : $this->model;

        $this->commentStatus ||  ($this->commentStatus = Comment::STATUS_APPROVED);
    }

    public function run()
    {
        if ( $this-> model )
            $r = array( 'condition' => 'model = :model AND status = :status',
                        'params' => array(
                                    ':model' => $this->model,
                                    ':status' => $this->commentStatus
                            ),
                        'order' => 'id DESC'
                        );
        else
            $r = array( 'condition' => 'status = :status',
                        'params' => array(
                                    ':status' => $this->commentStatus
                            ),
                        'order' => 'id DESC'
                        );



        $comments = Comment::model()->findAll();

        $this->render('lastcommentswidget', array('comments' => $comments));
    }
}