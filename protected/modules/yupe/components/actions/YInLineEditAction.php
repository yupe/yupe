<?php
namespace yupe\components\actions;

use CAction;
use CHttpException;
use CActiveRecord;
use Yii;

/**
 * Class YInLineEditAction
 * @package yupe\components\actions
 */
class YInLineEditAction extends CAction
{
    /**
     * @var
     */
    public $model;

    /**
     * @var
     */
    public $validAttributes;

    /**
     * @throws \CHttpException
     */
    public function init()
    {
        if (!$this->model || empty($this->validAttributes)) {
            throw new CHttpException(500);
        }
    }

    /**
     * @throws \CHttpException
     */
    public function run()
    {
        if (!Yii::app()->getRequest()->getIsAjaxRequest() || !Yii::app()->getRequest()->getIsPostRequest()) {
            throw new CHttpException(404);
        }

        $name = Yii::app()->getRequest()->getPost('name');
        $value = Yii::app()->getRequest()->getPost('value');
        $pk = Yii::app()->getRequest()->getPost('pk');

        if (!isset($name, $pk) || !in_array($name, $this->validAttributes)) {
            throw new CHttpException(404);
        }

        $model = CActiveRecord::model($this->model)->resetScope()->findByPk($pk);

        if (null === $model) {
            throw new CHttpException(404);
        }

        $model->$name = $value;

        if ($model->save()) {
            Yii::app()->ajax->success();
        }

        Yii::app()->ajax->rawText($model->getError($name), 500);
    }
}
