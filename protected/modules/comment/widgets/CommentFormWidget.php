<?php
class CommentFormWidget extends YWidget
{
    public $model;

    public $model_id;

    public $redirectTo;

    public function init()
    {
        $this->model = is_object($this->model) ? get_class($this->model)
            : $this->model;

        $this->model_id = (int)$this->model_id;
    }

    public function run()
    {
        $model = new Comment();

        $model->setAttributes(array(
                                   'model' => $this->model,
                                   'model_id' => $this->model_id
                              ));

        $this->render('commentformwidget', array('redirectTo' => $this->redirectTo, 'model' => $model));
    }
}

?>