<?php
class YAsyncResponse extends CApplicationComponent
{
    public $success         = true;
    public $failure         = false;
    public $resultParamName = 'result';
    public $dataParamName   = 'data';

    public function init()
    {
        return true;
    }

    private function setHeader()
    {
        header('Content-type: application/json');
    }

    public function success($data = null)
    {
        $this->setHeader();

        echo json_encode(array(
            $this->resultParamName => $this->success,
            $this->dataParamName   => $data,
        ));

        Yii::app()->end();
    }

    public function failure($data = null)
    {
        $this->setHeader();

        echo json_encode(array(
            $this->resultParamName => $this->failure,
            $this->dataParamName   => $data,
        ));

        Yii::app()->end();
    }

    public function raw($data)
    {
        $this->setHeader();

        echo json_encode($data);
        Yii::app()->end();
    }

    public function rawText($data)
    {
        echo $data;
        Yii::app()->end();
    }
}