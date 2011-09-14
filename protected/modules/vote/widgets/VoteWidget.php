<?php
class VoteWidget extends YWidget
{
    public $model;

    public $modelId;

    public $userId;

    public function init()
    {
        if (!$this->model || !$this->modelId)
        {
            throw new CException(Yii::t('vote', 'Укажите model и modelId для виджета VoteWidget!'));
        }

        if (!$this->userId)
        {
            $this->userId = Yii::app()->user->getId();
        }
    }

    public function run()
    {
        $vote = Vote::model()->find('model = :model AND modelId = :modelId AND userId = :userId', array(
                                                                                                       'model' => $this->model,
                                                                                                       'modelId' => $this->modelId,
                                                                                                       'userId' => $this->userId
                                                                                                  ));

        $this->render('votewidget', array('model' => $vote));
    }
}

?>