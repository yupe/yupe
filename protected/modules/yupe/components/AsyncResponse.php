<?php

/**
 * AsyncResponse - базовый класс для ajax ответа!
 *
 * В тех местах, где вам необходимо сделать вывод ajax-ответа
 * используем конструкцию вида:
 *
 *  Yii::app()->ajax->success(<message>) - в случае положительного ответа
 *  Yii::app()->ajax->failure(<message>) - в случае ошибки
 *
 *  Yii::app()->ajax->raw(<data>)        - для вывода данных (преобразуя
 *                                         их в json)
 *  Yii::app()->ajax->rawText(<data>)    - для вывода сообщения без
 *                                         преобразования (выводятся уже
 *                                         преобразованные в строку данные)
 *
 * @category YupeModule
 * @package  yupe.modules.yupe.components
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     http://yupe.ru
 *
 */

namespace yupe\components;

use CApplicationComponent;
use Yii;

class AsyncResponse extends CApplicationComponent
{
    public $success         = true;
    public $failure         = false;
    public $resultParamName = 'result';
    public $dataParamName   = 'data';

    public function init()
    {
        return true;
    }

    public function success($data = null)
    {
        ContentType::setHeader(ContentType::TYPE_JSON);

        echo json_encode(array(
            $this->resultParamName => $this->success,
            $this->dataParamName   => $data,
        ));

        Yii::app()->end();
    }

    public function failure($data = null)
    {
        ContentType::setHeader(ContentType::TYPE_JSON);

        echo json_encode(array(
            $this->resultParamName => $this->failure,
            $this->dataParamName   => $data,
        ));

        Yii::app()->end();
    }

    public function raw($data)
    {
        ContentType::setHeader(ContentType::TYPE_JSON);

        echo json_encode($data);
        Yii::app()->end();
    }

    public function rawText($data)
    {
        echo $data;
        Yii::app()->end();
    }
}