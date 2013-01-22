<?php
/**
 * Отображение для _view:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$this->renderPartial(
    Yii::app()->controller->action->id, array(
        'data' => isset($data) ? $data : array(),
    )
);?>