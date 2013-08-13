<?php
class LastCommentsWidget extends YWidget
{
    public $model;
    public $commentStatus;
    public $limit          = 10;
    public $onlyWithAuthor = true;

    public function init()
    {
        if ($this->model)
            $this->model = is_object($this->model) ? get_class($this->model) : $this->model;

        $this->commentStatus || ($this->commentStatus = Comment::STATUS_APPROVED);
    }

    public function run()
    {
        $criteria = new CDbCriteria(array(
            'condition' => 'status = :status',
            'params'    => array(':status' => $this->commentStatus),
            'limit'     => $this->limit,
            'order'     => 'id DESC',
        ));

        if ($this->model)
        {
            $criteria->addCondition('model = :model');
            $criteria->params[':model'] = $this->model;
        }

        if ($this->onlyWithAuthor)
            $criteria->addCondition('user_id is not null');

        $comments = Comment::model()->findAll($criteria);

        $this->render('lastcomments', array('models' => $comments));
    }
}