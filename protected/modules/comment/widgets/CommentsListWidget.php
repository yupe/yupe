<?php
/**
 * File Doc Comment
 * Виджет для отрисовки списка комментариев:
 *
 * @category YupeWidgets
 * @package  YupeCMS
 * @author   Yupe Team <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://yupe.ru
 *
 **/

/**
 * Виджет для отрисовки списка комментариев:
 *
 * @var      public $model     - модель которую комментируют
 * @var      public $modelId   - ID-записи модели, которую комментируют
 * @var      public $label     - лейбл для заглавия, перед списком комментариев
 * @var      public $comment   - инстанс комментария, если используется для отрисовки 1го комментария
 *
 * @method   public  init       - Инициализация виджета
 * @method   private _buildTree - Метод построения дерева комментариев
 * @method   public  run        - Запуск виджета
 *
 * @category YupeWidgets
 * @package  YupeCMS
 * @author   Yupe Team <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://yupe.ru
 *
 **/
class CommentsListWidget extends YWidget
{
    public $model;
    public $modelId;
    public $label;
    public $comment = null;
    public $comments;
    public $status;

    /**
     * Инициализация виджета:
     *
     * @return void
     **/
    public function init()
    {
        if ($this->comment === null) {
            Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/web/js/commentlist.js');
            if ((empty($this->model) && empty($this->modelId)) && empty($this->comments)) {
                throw new CException(
                    Yii::t(
                        'CommentModule.comment',
                        'Пожалуйста, укажите "model" и "modelId" для виджета "{widget}" !',
                        array(
                            '{widget}' => get_class($this),
                        )
                    )
                );
            }

            $this->model = is_object($this->model) ? get_class($this->model) : $this->model;
            $this->modelId = (int)$this->modelId;
        }

        if (empty($this->label)) {
            $this->label = Yii::t('CommentModule.comment', 'Комментариев');
        }

        if (empty($this->status)) {
            $this->status = Comment::STATUS_APPROVED;
        }
    }

    /**
     * Функция для формирования иерархического дерева
     *
     * @param mixed &$data - данные
     *
     * @copyright  2013 YupeTeam =)
     *
     * @return array - дерево
     */
    private function _buildTree(&$data)
    {
        $tree = array();
        $assoc = array();
        foreach ($data as &$row) {
            $id = '_' . str_pad($row->id, 10, '0', STR_PAD_LEFT);
            $pid = '_' . str_pad($row->parent_id, 10, '0', STR_PAD_LEFT);
            if (empty($row->parent_id)) {
                $tree["{$id}_0"]['row'] = & $row;
                $tree["{$id}_0"]['childOf'] = array();
            } else {
                $tree["{$id}_0"]['row'] = & $row;
                if (isset($assoc["{$pid}_0"])) {
                    $key = $assoc["{$pid}_0"];
                } else {
                    $key = "{$pid}_0";
                }
                $tree["{$id}_0"]['childOf'] = array_merge(
                    $tree[$key]['childOf'],
                    (array)$pid
                );
                $assoc["{$id}_0"] = join('_', array_merge($tree["{$id}_0"]['childOf'], (array)$id));
                $tree[join('_', array_merge($tree["{$id}_0"]['childOf'], (array)$id))] = & $tree["{$id}_0"];
                unset($tree["{$id}_0"]);
            }
        }
        ksort($tree);
        return $tree;
    }

    /**
     * Запуск виджета:
     *
     * @return void
     **/
    public function run()
    {
        if ($this->comment === null) {
            $comments = Yii::app()->cache->get("Comment{$this->model}{$this->modelId}");
            if (empty($comments)) {
                if (empty($this->comments)) {
                    $this->comments = Comment::model()->with('author')->findAll(
                        array(
                            'condition' => 't.model = :model AND t.model_id = :modelId AND t.status = :status',
                            'params' => array(
                                ':model' => $this->model,
                                ':modelId' => $this->modelId,
                                ':status' => $this->status,
                            ),
                            'with' => array('author'),
                            'order' => 't.id',
                        )
                    );
                }
                $comments = $this->_buildTree($this->comments);
                Yii::app()->cache->set("Comment{$this->model}{$this->modelId}", $comments);
            }
            $this->render(
                'commentslistwidget',
                array(
                    'comments' => $comments
                )
            );
        } else {

            $this->render(
                'commentslistwidget',
                array(
                    'comments' => array(0)
                )
            );
        }
    }
}