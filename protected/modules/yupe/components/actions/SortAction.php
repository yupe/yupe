<?php

namespace yupe\components\actions;

use CAction;
use CHttpException;
use CActiveRecord;
use Yii;
use CDbException;
use Exception;


/**
 * Class SortAction
 * @package yupe\components\actions
 */
class SortAction extends CAction
{
    /**
     * @var
     */
    public $model;

    /**
     * @var string
     */
    public $attribute = 'position';

    /**
     * @throws \CHttpException
     */
    public function init()
    {
        parent::init();

        if (!$this->model || empty($this->attribute)) {
            throw new CHttpException(404);
        }
    }

    /**
     * @throws \CHttpException
     */
    public function run()
    {
        if (!Yii::app()->getRequest()->getIsPostRequest() || !Yii::app()->getRequest()->getIsAjaxRequest()) {
            throw new CHttpException(404);
        }

        $items = Yii::app()->getRequest()->getPost('sortOrder');

        if (empty($items)) {
            throw new CHttpException(404);
        }

        $ar = CActiveRecord::model($this->model);

        if (empty($ar)) {
            throw new CHttpException(404);
        }

        $transaction = Yii::app()->getDb()->beginTransaction();

        try {

            foreach ($items as $id => $priority) {

                $model = $ar->resetScope()->findByPk($id);

                if (null === $model) {
                    continue;
                }

                $model->{$this->attribute} = (int)$priority;

                if (!$model->update($this->attribute)) {
                    throw new CDbException('Error sort items!');
                }
            }
            $transaction->commit();
            Yii::app()->ajax->success();
        } catch (Exception $e) {
            $transaction->rollback();
            Yii::app()->ajax->failure();
        }
    }
} 
