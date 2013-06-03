<?php
class CommentFormWidget extends YWidget
{
    public $model;
    public $modelId;
    public $redirectTo;

    public function init()
    {
        Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/web/js/commentform.js');
        $this->model   = is_object($this->model) ? get_class($this->model) : $this->model;
        $this->modelId = (int) $this->modelId;
    }

    public function run()
    {
        $model = new Comment;

        $module = Yii::app()->getModule('comment');

        $model->setAttributes(array(
            'model'    => $this->model,
            'model_id' => $this->modelId,
        ));

        $this->render('commentformwidget', array(
            'redirectTo' => $this->redirectTo,
            'model'      => $model,
            'module'      => $module,
        ));
    }
}