<?php
class CommentFormWidget extends YWidget
{
    public $model;

    public $modelId;

    public $redirectTo;

    public function init()
    {
        $this->model = is_object($this->model) ? get_class($this->model) : $this->model;

        $this->modelId = (int)$this->modelId;
    }

    public function run()
    {
        $model = new Comment;

        $model->setAttributes(array(
                                   'model' => $this->model,
<<<<<<< HEAD
                                   'modelId' => $this->modelId
=======
                                   'model_id' => $this->modelId
>>>>>>> aca9c53d8d236fff441ef873840104676fd6fc0d
                              ));

        $this->render('commentformwidget', array('redirectTo' => $this->redirectTo, 'model' => $model));
    }
}