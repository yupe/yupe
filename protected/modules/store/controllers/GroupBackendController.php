<?php

use yupe\components\controllers\BackController;

class GroupBackendController extends BackController
{
    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin'],],
            ['deny',],
        ];
    }

    public function filters()
    {
        return CMap::mergeArray(
            parent::filters(),
            [
                'ajaxOnly + index, data',
                'postOnly + create, delete',
            ]
        );
    }

    public function actionIndex()
    {
        $this->renderPartial('/productBackend/_image_groups_grid', ['imageGroup' => ImageGroup::model()]);
    }

    public function actionCreate()
    {
        $model = new ImageGroup();

        $data = Yii::app()->getRequest()->getPost('ImageGroup');

        if ($data) {
            $model->setAttributes($data);

            if ($model->save()) {
                Yii::app()->ajax->success(Yii::t('StoreModule.store', 'The group is successfully created'));
            }
        }

        Yii::app()->ajax->error(Yii::t('StoreModule.store', 'Failed to create group'));
    }

    public function actionDelete($id)
    {
        if (ImageGroup::model()->findByPk($id)->delete()) {
            Yii::app()->ajax->success(Yii::t('StoreModule.store', 'The group is successfully deleted'));
        }

        Yii::app()->ajax->error(Yii::t('StoreModule.store', 'Failed to delete group'));
    }

    public function actionData()
    {
        Yii::app()->ajax->success(ImageGroupHelper::all());
    }
}