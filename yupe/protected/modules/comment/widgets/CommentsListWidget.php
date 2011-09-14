<?php
class CommentsListWidget extends YWidget
{
    public $model;
    
    public $modelId;
    
    public $commentStatus;
    
    public function init()
    {
        if(!$this->model || !$this->modelId)
        {
            throw new CException(Yii::t('comment','Пожалуйста, укажите "model" и "modelId" для виджета "{widget}" !',array('{widget}' => get_class($this))));
        }
        
        $this->model = is_object($this->model) ? get_class($this->model) : $this->model;
        
        $this->modelId = (int)$this->modelId;
        
        $this->commentStatus = Comment::STATUS_APPROVED;
    }
    
    public function run()
    {       
        $comments = Comment::model()->findAll(array(
            'condition' => 'model = :model AND modelId = :modelId AND status = :status',
            'params'    => array(
                ':model' => $this->model,
                ':modelId' => $this->modelId,
                ':status'  => $this->commentStatus
             ),
            'order' => 'creationDate DESC'
        ));
        
        $this->render('commentslistwidget',array('comments' => $comments));
    }
}
?>