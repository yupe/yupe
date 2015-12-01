<?php
Yii::import('application.modules.comment.CommentModule');

/**
 * Comment Widget
 *
 * @category YupeWidget
 * @package  yupe.modules.comment.widgets
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.9.4
 * @link     http://yupe.ru
 *
 **/
class CommentsWidget extends yupe\widgets\YWidget
{
    /**
     * @var CActiveRecord
     */
    public $model;
    /**
     * @var
     */
    public $redirectTo;
    /**
     * @var
     */
    public $status;
    /**
     * @var bool
     */
    public $showComments = true;
    /**
     * @var bool
     */
    public $showForm = true;
    /**
     * @var bool
     */
    public $allowGuestComment = false;
    /**
     * @var string
     */
    public $view = 'comments';

    /**
     * @throws CException
     */
    public function init()
    {
        if (null === $this->model && empty($this->comments)) {
            throw new CException(
                Yii::t(
                    'CommentModule.comment',
                    'Please, set "model" property for "{widget}" widget!',
                    [
                        '{widget}' => get_class($this),
                    ]
                )
            );
        }

        if (!$this->showComments && !$this->showForm) {
            throw new CException(
                Yii::t(
                    'CommentModule.comment',
                    'Nothing to show. Please, set "showForm" or "showComments" property to true.'
                )
            );
        }

        if (null === $this->status) {
            $this->status = Comment::STATUS_APPROVED;
        }

        $this->allowGuestComment = Yii::app()->getModule('comment')->allowGuestComment;
        $this->generateTokens();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $model = new Comment;
        $model->setAttributes(
            [
                'model' => get_class($this->model),
                'model_id' => $this->model->id,
            ]
        );

        $this->render(
            $this->view,
            [
                'comments' => $this->getComments(),
                'model' => $model,
                'redirectTo' => $this->redirectTo,
                'spamField' => Yii::app()->getUser()->getState('spamField'),
                'spamFieldValue' => Yii::app()->getUser()->getState('spamFieldValue'),
                'module' => Yii::app()->getModule('comment'),
            ]
        );
    }

    /**
     * @return bool
     */
    public function isAllowed()
    {
        return $this->allowGuestComment || !Yii::app()->getUser()->getIsGuest();
    }

    /**
     * @return array
     */
    protected function getComments()
    {
        if ($this->showComments) {
            if (false === ($comments = Yii::app()->getCache()->get($this->getCacheKey()))) {
                $comments = Yii::app()->commentManager->getCommentsForModel(
                    get_class($this->model),
                    $this->model->id,
                    $this->status
                );
                Yii::app()->getCache()->set($this->getCacheKey(), $comments);
            }

            return $comments;
        }

        return [];
    }

    /**
     * @return string
     */
    protected function getCacheKey()
    {
        $class = get_class($this->model);

        return "Comment{$class}{$this->model->id}";
    }

    /**
     *
     */
    protected function generateTokens()
    {
        Yii::app()->getUser()->setState('spamField', md5(Yii::app()->userManager->hasher->generateRandomToken(8)));
        Yii::app()->getUser()->setState('spamFieldValue', md5(Yii::app()->userManager->hasher->generateRandomToken(8)));
    }
}
