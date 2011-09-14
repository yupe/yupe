<?php
class YAsyncResponse extends CComponent
{
    public $success = true;

    public $failure = false;

    public $resultParamName = 'result';

    public $dataParamName = 'data';

    public function init()
    {
    }

    public function success($data = null)
    {
        echo json_encode(array($this->resultParamName => $this->success, $this->dataParamName => $data));
        Yii::app()->end();
    }

    public function failure($data = null)
    {
        echo json_encode(array($this->resultParamName => $this->failure, $this->dataParamName => $data));
        Yii::app()->end();
    }
}

?>
