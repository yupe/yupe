<?php
/**
 * New comment event
 *
 * @category YupeComponents
 * @package  yupe.modules.comment.components
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://yupe.ru
 *
 **/

namespace application\modules\comment\components;

use CModelEvent;

class NewCommentEvent extends CModelEvent
{
    /**
     * Инстанс модуля:
     **/
    public $module;

    /**
     * Инстанс комментария:
     **/
    public $comment;
}