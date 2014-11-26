<?php

/**
 * Виджет для вывода последних комментарие
 *
 * @category YupeWidgets
 * @package  yupe.modules.comment.widgets
 * @author   Yupe Team <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://yupe.ru
 *
 **/
class LastCommentsWidget extends yupe\widgets\YWidget
{
    public $model;
    public $commentStatus;
    public $limit = 10;
    public $onlyWithAuthor = true;
    public $view = 'lastcomments';

    public function init()
    {
        if ($this->model) {
            $this->model = is_object($this->model) ? get_class($this->model) : $this->model;
        }

        $this->commentStatus || ($this->commentStatus = Comment::STATUS_APPROVED);
    }

    public function run()
    {
        $criteria = new CDbCriteria([
            'condition' => 'status = :status AND id<>root',
            'params'    => [':status' => $this->commentStatus],
            'limit'     => $this->limit,
            'order'     => 'id DESC',
        ]);

        if ($this->model) {
            $criteria->addCondition('model = :model');
            $criteria->params[':model'] = $this->model;
        }

        if ($this->onlyWithAuthor) {
            $criteria->addCondition('user_id is not null');
        }

        $comments = Comment::model()->findAll($criteria);

        $this->render($this->view, ['models' => $comments]);
    }
}
