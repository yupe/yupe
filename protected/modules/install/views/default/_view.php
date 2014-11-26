<?php
/**
 * Отображение для _view:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
$this->renderPartial(
    Yii::app()->controller->action->id,
    [
        'data' => isset($data) ? $data : [],
    ]
);
