<?php
/**
 * Виджет для отрисовки дерева комментариев
 *
 * @category YupeWidgets
 * @package  yupe.modules.comment.widgets
 * @author   Yupe Team <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://yupe.ru
 *
 **/

Yii::import('application.modules.comment.CommentModule');

class CommentsListWidget extends yupe\widgets\YWidget
{
    public $model;
    public $modelId;
    public $label;   
    public $comments;
    public $status;
    public $view = 'commentslistwidget';

    /**
     * Инициализация виджета:
     * @throws CException
     * @return void
     **/
    public function init()
    {
        Yii::app()->clientScript->registerScriptFile(
            Yii::app()->assetManager->publish(Yii::app()->theme->basePath . '/web/js/comments.js')
        );

        if ((empty($this->model) && empty($this->modelId)) && empty($this->comments)) {
            throw new CException(
                Yii::t(
                    'CommentModule.comment',
                    'Please, set "model" and "modelId" for "{widget}" widget!',
                    array(
                        '{widget}' => get_class($this),
                    )
                )
            );
        }

        $this->model = is_object($this->model) ? get_class($this->model) : $this->model;
        $this->modelId = (int)$this->modelId;

        if (empty($this->label)) {
            $this->label = Yii::t('CommentModule.comment', 'Comments');
        }

        if (empty($this->status)) {
            $this->status = Comment::STATUS_APPROVED;
        }
    }

    /**
     * Запуск виджета:
     *
     * @return void
     **/
    public function run()
    {       
        $comments = Yii::app()->cache->get("Comment{$this->model}{$this->modelId}");

        if (empty($comments)) {
            if (empty($this->comments)) {                 
                $this->comments = Comment::model()->findAll(
                    array(
                        'condition' => 't.model = :model AND t.model_id = :modelId AND t.status = :status',
                        'params' => array(
                            ':model' => $this->model,
                            ':modelId' => $this->modelId,
                            ':status' => $this->status,
                        ),                         
                        'order' => 't.lft',
                    )
                );                    
            }
            //unset($this->comments[0]); // remove "root" node
            foreach($this->comments as $k=>$v) {
                if($v->id == $v->root){
                    unset($this->comments[$k]);
                }
            }
            $comments = $this->comments;
            Yii::app()->cache->set("Comment{$this->model}{$this->modelId}", $comments);
        }

        $this->render($this->view, array('comments' => $comments));        
    }
}