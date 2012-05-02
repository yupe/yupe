<?php
class CommentsListWidget extends YWidget
{
    public $model;
    public $modelId;

    public function init()
    {
        if (!$this->model || !$this->modelId)
            throw new CException(Yii::t('comment', 'Пожалуйста, укажите "model" и "modelId" для виджета "{widget}" !', array(
                '{widget}' => get_class($this),
            )));

        $this->model = is_object($this->model)
            ? get_class($this->model)
            : $this->model;

        $this->modelId = (int)$this->modelId;
    }

    public function run()
    {
        if(!$comments = Yii::app()->cache->get("Comment{$this->model}{$this->modelId}"))
        {
            $comments = Comment::model()->findAll(array(
                'condition' => 'model = :model AND model_id = :modelId AND status = :status',
                'params' => array(
                    ':model' => $this->model,
                    ':modelId' => $this->modelId,
                    ':status' => Comment::STATUS_APPROVED,
                ),
                'order' => 'id',
            ));

            Yii::app()->cache->set("Comment{$this->model}{$this->modelId}", $comments);
        }

        $this->render('commentslistwidget', array(
            'comments' => $comments,
        ));
    }
}