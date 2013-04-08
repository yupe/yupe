<?php
/**
 * File Doc Comment
 * Виджет для отрисовки списка комментариев:
 *
 * @category YupeWidgets
 * @package  YupeCMS
 * @author   Yupe Team <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1 (dev)
 * @link     http://yupe.ru
 *
 **/

/**
 * Виджет для отрисовки списка комментариев:
 *
 * @category YupeWidgets
 * @package  YupeCMS
 * @author   Yupe Team <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1 (dev)
 * @link     http://yupe.ru
 *
 **/
class CommentsListWidget extends YWidget
{
    public $model;
    public $modelId;
    public $label;
    public $comment = null;
    public $comments = null;
    public $fromController = true;

    /**
     * Инициализация виджета:
     *
     * @return void
     **/
    public function init()
    {
        Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/web/js/commentlist.js');
        if ($this->fromController !== false) {
            if (!$this->model || !$this->modelId)
                throw new CException(
                    Yii::t(
                        'CommentModule.comment', 'Пожалуйста, укажите "model" и "modelId" для виджета "{widget}" !', array(
                            '{widget}' => get_class($this),
                        )
                    )
                );

            $this->model   = is_object($this->model) ? get_class($this->model) : $this->model;
            $this->modelId = (int) $this->modelId;

            if (!$this->label)
                $this->label = Yii::t('CommentModule.comment', 'Комментариев');
        } else 
            return $this->renderOneComment($this->comment);
    }

    /**
     * Запуск виджета:
     *
     * @return void
     **/
    public function run()
    {
        if ($this->fromController !== false) {
            if (!$this->comments = Yii::app()->cache->get("Comment{$this->model}{$this->modelId}")) {
                $this->comments = Comment::model()->findAll(
                    array(
                        'condition' => 't.model = :model AND t.model_id = :modelId AND t.status = :status',
                        'params'    => array(
                            ':model'   => $this->model,
                            ':modelId' => $this->modelId,
                            ':status'  => Comment::STATUS_APPROVED,
                        ),
                        'with'      => array('author'),
                        'order'     => 't.id',
                    )
                );
                Yii::app()->cache->set("Comment{$this->model}{$this->modelId}", $this->comments);
            }
            $this->render('commentslistwidget');
        }
    }

    /**
     * Метод отрисовки одного комментария:
     *
     * @param class $comment - инстанс комментария
     * @param int   $level   - уровень вложенности
     *
     * @return void
     **/
    public function renderOneComment($comment, $level = 0)
    {
        $this->render(
            'one_comment', array(
                'comment' => $comment,
                'level'   => $level,
            )
        );
    }

    /**
     * Генерируем комментарии:
     *
     * @param int $level     - текущий уровень
     * @param int $parent_id - id-родителя
     *
     * @return void
     **/
    public function nestedComment($level = 0, $parent_id = null)
    {
        foreach ($this->comments as $comment) {
            if ($parent_id === $comment->parent_id) {
                $this->renderOneComment($comment, $level);
            }
        }
    }
}