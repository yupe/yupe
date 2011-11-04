<?php
class CommentsListWidget extends YWidget
{
    public $model;

    public $model_id;

    public $commentStatus;

    public function init()
    {
        if (!$this->model || !$this->model_id)
        {
            throw new CException(Yii::t('comment', 'Пожалуйста, укажите "model" и "model_id" для виджета "{widget}" !', array('{widget}' => get_class($this))));
        }

        $this->model = is_object($this->model) ? get_class($this->model)
            : $this->model;

        $this->model_id = (int)$this->model_id;

        $this->commentStatus = Comment::STATUS_APPROVED;
    }

    public function run()
    {
        $comments = Comment::model()->findAll(array(
                                                   'condition' => 'model = :model AND model_id = :model_id AND status = :status',
                                                   'params' => array(
                                                       ':model' => $this->model,
                                                       ':model_id' => $this->model_id,
                                                       ':status' => $this->commentStatus
                                                   ),
                                                   'order' => 'id'
                                              ));

        $this->render('commentslistwidget', array('comments' => $comments));
    }
}