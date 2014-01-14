<?php
/**
 * Виджет отрисовки формы для добавления комментария
 *
 * @category YupeWidget
 * @package  yupe.modules.comment.widgets
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/
class CommentFormWidget extends yupe\widgets\YWidget
{
    public $model;
    public $modelId;
    public $redirectTo;
    public $view = 'commentformwidget';
    public $allowGuestComment = false;

    public function init()
    {
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->assetManager->publish(Yii::app()->theme->basePath . '/web/js/comments.js')
        );
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

        if($this->allowGuestComment == false && !Yii::app()->user->isAuthenticated()) {
            $this->view = 'commentnotallowed';
        }

        $this->render($this->view, array(
            'redirectTo' => $this->redirectTo,
            'model'      => $model,
            'module'     => $module,
        ));
    }
}