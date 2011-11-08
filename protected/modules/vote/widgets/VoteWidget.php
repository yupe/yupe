<?php
class VoteWidget extends YWidget
{
    public $model;

    public $model_id;

    public $user_id;

    public function init()
    {
        if (!$this->model || !$this->model_id)        
            throw new CException(Yii::t('vote', 'Укажите model и model_id для виджета VoteWidget!'));        

        if (!$this->user_id)        
            $this->user_id = Yii::app()->user->getId();        
    }

    public function run()
    {
        $vote = Vote::model()->find('model = :model AND model_id = :model_id AND user_id = :user_id', array(
                                                                                                       'model' => $this->model,
                                                                                                       'model_id' => $this->model_id,
                                                                                                       'user_id' => $this->user_id
                                                                                                  ));

        $this->render('votewidget', array('model' => $vote));
    }
}