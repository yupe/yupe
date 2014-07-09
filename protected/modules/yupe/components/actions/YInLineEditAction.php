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
        parent::init();

        if(!$this->model || empty($this->validAttributes)) {
            throw new CHttpException(500);
        }
    }

    /**
     * @throws \CHttpException
     */
    public function run()
    {
        if (!Yii::app()->request->getIsAjaxRequest() || !Yii::app()->request->getIsPostRequest()) {
            throw new CHttpException(404);
        }

        $name = Yii::app()->request->getPost('name');
        $value = Yii::app()->request->getPost('value');
        $pk = Yii::app()->request->getPost('pk');

        if (!isset($name, $value, $pk)) {
            throw new CHttpException(404);
        }

        if (!in_array($name, $this->validAttributes)) {
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

        throw new CHttpException(500, $model->getError($name));
    }
} 