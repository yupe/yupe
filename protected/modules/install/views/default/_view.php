<?php
/**
 * Отображение для _view:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <support@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     https://yupe.ru
 **/
$this->renderPartial(
    Yii::app()->controller->action->id,
    [
        'data' => isset($data) ? $data : [],
    ]
);
