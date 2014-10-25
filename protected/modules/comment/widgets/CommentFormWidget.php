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
        $this->model = is_object($this->model) ? get_class($this->model) : $this->model;
        $this->modelId = (int)$this->modelId;
        $this->allowGuestComment = Yii::app()->getModule("comment")->allowGuestComment ? true : false;
    }

    public function run()
    {
        $model = new Comment;

        $model->setAttributes(
            [
                'model' => $this->model,
                'model_id' => $this->modelId,
            ]
        );

        if ($this->allowGuestComment == false && !Yii::app()->getUser()->isAuthenticated()) {
            $this->view = 'commentnotallowed';
        }

        Yii::app()->getUser()->setState('spamField', md5(Yii::app()->userManager->hasher->generateRandomToken(8)));

        Yii::app()->getUser()->setState('spamFieldValue', md5(Yii::app()->userManager->hasher->generateRandomToken(8)));

        $this->render(
            $this->view,
            [
                'redirectTo' => $this->redirectTo,
                'model' => $model,
                'module' => Yii::app()->getModule('comment'),
                'spamField' => Yii::app()->getUser()->getState('spamField'),
                'spamFieldValue' => Yii::app()->getUser()->getState('spamFieldValue')
            ]
        );
    }
}
