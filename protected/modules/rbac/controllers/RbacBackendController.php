<?php

class RbacBackendController extends yupe\components\controllers\BackController
{

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render(
            'view',
            array(
                'model' => $this->loadModel($id),
            )
        );
    }

    public function actionInlineEdit()
    {
        if (!Yii::app()->request->isPostRequest || !Yii::app()->request->isAjaxRequest) {
            throw new CHttpException(404);
        }

        $pk    = Yii::app()->request->getPost('pk');
        $value = Yii::app()->request->getPost('value');
        $name  = Yii::app()->request->getPost('name');

        if(!isset($pk, $name)) {
            throw new CHttpException(404);
        }

        $model = AuthItem::model()->find('name = :name', array(':name' => $pk));

        if (null === $model) {
            throw new CHttpException(403);
        }

        $model->$name = $value;

        if (!$model->save()) {
            throw new CHttpException(500, $model->getError($name));
        }

        Yii::App()->ajax->success();
    }


    public function actionAssign($id)
    {
        $user = Users::model()->findByPk((int)$id);

        if (!$user) {
            throw new CHttpException(404);
        }

        $items = AuthItem::model()->findAll(array('order' => 'type DESC'));

        $itemsData = CHtml::listData(AuthItemChild::model()->findAll(), 'child', 'parent');

        if (Yii::app()->request->isPostRequest && count($_POST)) {
            $itemsArray = CHtml::listData($items, 'name', 'description');

            $transaction = Yii::app()->db->beginTransaction();

            try {
                if (count($_POST)) {
                    AuthAssignment::model()->deleteAll(
                        'userid = :userid',
                        array(
                            ':userid' => (int)$user->id
                        )
                    );

                    foreach ($_POST as $op => $val) {
                        if (!isset($itemsArray[$op])) {
                            continue;
                        }

                        $model = new AuthAssignment;

                        $model->setAttributes(
                            array(
                                'userid' => $user->id,
                                'itemname' => $op
                            )
                        );

                        if (!$model->save()) {
                            throw new CDbException('При сохранении произошла ошибка!');
                        }
                    }
                }

                $transaction->commit();

                Yii::app()->user->setFlash('notice', 'Данные обновлены!');

                $this->redirect(array('assign', 'id' => $user->id));
            } catch (Exception $e) {
                Yii::app()->user->setFlash('error', $e->getMessage());

                $transaction->rollback();
            }
        }

        //построить дерево        
        $tree = array();

        foreach ($items as $item) {
            if ($item->type === AuthItem::TYPE_ROLE && !isset($tree[$item->name])) {
                $tree[$item->name] = array(
                    'text' => CHtml::checkBox(
                        $item->name,
                        Yii::app()->user->checkAccess($item->name, $user->id),
                        array('name' => 'operations', 'class' => 'root')
                    ) . $item->description . " ({$item->getType()})"
                );
            }

            if ($item->type === AuthItem::TYPE_TASK) {
                // проверить есть ли для нее родитель
                if (isset($itemsData[$item->name]) && $itemsData[$item->name]) {
                    $tree[$itemsData[$item->name]]['children'][$item->name] = array(
                        'text' => CHtml::checkBox(
                            $item->name,
                            Yii::app()->user->checkAccess($item->name, $user->id),
                            array('name' => 'operations', 'class' => 'root')
                        ) . $item->description . " ({$item->getType()})"
                    );
                } else {
                    $tree[$item->name] = array(
                        'text' => CHtml::checkBox(
                            $item->name,
                            Yii::app()->user->checkAccess($item->name, $user->id),
                            array('name' => 'operations')
                        ) . $item->description . " ({$item->getType()})"
                    );
                }
            }


            if ($item->type == AuthItem::TYPE_OPERATION) {
                if (isset($itemsData[$item->name]) && $itemsData[$item->name]) {
                    // задача по своей сути
                    $parent = $itemsData[$item->name];

                    if (isset($itemsData[$parent]) && $itemsData[$parent]) {
                        $tree[$itemsData[$parent]]['children'][$itemsData[$item->name]]['children'][$item->name] = array(
                            'text' => CHtml::checkBox(
                                $item->name,
                                Yii::app()->user->checkAccess($item->name, $user->id),
                                array('name' => 'operations')
                            ) . $item->description . " ({$item->getType()})"
                        );
                    } else {
                        $tree[$itemsData[$item->name]]['children'][$item->name] = array(
                            'text' => CHtml::checkBox(
                                $item->name,
                                Yii::app()->user->checkAccess($item->name, $user->id),
                                array('name' => 'operations')
                            ) . $item->description . " ({$item->getType()})"
                        );
                    }
                } else {
                    $tree[$item->name] = array(
                        'text' => CHtml::checkBox(
                            $item->name,
                            Yii::app()->user->checkAccess($item->name, $user->id),
                            array('name' => 'operations')
                        ) . $item->description . " ({$item->getType()})"
                    );
                }
            }
        }

        $this->render('assign', array('tree' => $tree, 'model' => $user));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new AuthItem;

        $operationsList = $tasksList = array();

        $operations = AuthItem::model()->findAll(
            'type = :type',
            array(
                ':type' => AuthItem::TYPE_OPERATION
            )
        );

        foreach ($operations as $op) {
            $operationsList[$op->name] = $op->description . "({$op->name})";
        }

        $tasks = AuthItem::model()->findAll(
            'type = :type',
            array(
                ':type' => AuthItem::TYPE_TASK
            )
        );

        foreach ($tasks as $task) {
            $tasksList[$task->name] = $task->description . "({$task->name})";
        }

        if (Yii::app()->request->isPostRequest && isset($_POST['AuthItem'])) {
            $transaction = Yii::app()->db->beginTransaction();

            try {

                $model->attributes = Yii::app()->request->getPost('AuthItem');

                if ($model->save()) {

                    $children = array();

                    if ($model->type == AuthItem::TYPE_TASK) {
                        $children = Yii::app()->request->getPost('operations');
                    } elseif ($model->type == AuthItem::TYPE_ROLE) {
                        $children = Yii::app()->request->getPost('tasks');
                    }

                    // сохранить чайлдов
                    if (!empty($children)) {

                        foreach ($children as $name) {

                            $child = new AuthItemChild;

                            $child->setAttributes(
                                array(
                                    'parent' => $model->name,
                                    'child' => $name
                                )
                            );

                            if (!$child->save()) {
                                throw new CDbException('Ошибка при сохранении связанных объектов!');
                            }
                        }
                    }

                    $transaction->commit();

                    Yii::app()->user->setFlash('success', 'Действие добавлено!');

                    $this->redirect(array('view', 'id' => $model->name));
                }
            } catch (Exception $e) {

                Yii::app()->user->setFlash('error', $e->getMessage());

                $transaction->rollback();
            }
        }

        $this->render(
            'create',
            array(
                'model' => $model,
                'operations' => $operationsList,
                'tasks' => $tasksList
            )
        );
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = AuthItem::model()->with('parents.parentItem')->findByPk($id);

        $operationsList = $tasksList = $listModels = array();

        if ($model->type == AuthItem::TYPE_TASK) {
            $operations = AuthItem::model()->findAll(
                'type = :type',
                array(
                    ':type' => AuthItem::TYPE_OPERATION
                )
            );

            foreach ($operations as $op) {
                $listModels[$op->name] = $op->description . "({$op->name})";
            }
        } elseif ($model->type == AuthItem::TYPE_ROLE) {

            $tasks = AuthItem::model()->findAll(
                'type = :type',
                array(
                    ':type' => AuthItem::TYPE_TASK
                )
            );

            foreach ($tasks as $task) {
                $listModels[$task->name] = $task->description . "({$task->name})";
            }
        }

        foreach ($model->parents as $item) {
            if ($item->childItem->type == AuthItem::TYPE_OPERATION) {
                $operationsList[$item->childItem->name] = $item->childItem->description . " ({$item->childItem->name})";
            } elseif ($item->childItem->type == AuthItem::TYPE_TASK) {
                $tasksList[$item->childItem->name] = $item->childItem->description . " ({$item->childItem->name})";
            }
        }

        if (Yii::app()->request->isPostRequest && isset($_POST['AuthItem'])) {

            $transaction = Yii::app()->db->beginTransaction();

            try {

                $model->attributes = $_POST['AuthItem'];

                if ($model->save()) {

                    $items = array();

                    if ($model->type == AuthItem::TYPE_TASK) {
                        $items = Yii::app()->request->getPost('operations', array());
                    } elseif ($model->type == AuthItem::TYPE_ROLE) {
                        $items = Yii::app()->request->getPost('tasks', array());
                    }

                    // удалим и создадим чайлдов заново
                    AuthItemChild::model()->deleteAll(
                        'parent = :parent',
                        array(
                            ':parent' => $model->name
                        )
                    );


                    if (count($items)) {

                        foreach ($items as $name) {

                            $child = new AuthItemChild;

                            $child->setAttributes(
                                array(
                                    'parent' => $model->name,
                                    'child' => $name
                                )
                            );

                            if (!$child->save()) {
                                throw new CException('Ошибка при сохранении связанных объектов!');
                            }
                        }
                    }

                    $transaction->commit();

                    Yii::app()->user->setFlash('success', 'Действие изменено!');

                    $this->redirect(array('update', 'id' => $model->name));
                }
            } catch (Exception $e) {
                Yii::app()->user->setFlash('error', $e->getMessage());

                $transaction->rollback();
            }
        }

        $this->render(
            'update',
            array(
                'model' => $model,
                'operations' => $operationsList,
                'tasks' => $tasksList,
                'listModels' => $listModels
            )
        );
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            try {
                $this->loadModel($id)->delete();
            } catch (CDbException $e) {
                Yii::log($e->__toString(), CLogger::LEVEL_ERROR);
                throw new CHttpException(500, 'Невозможно удалить запись!');
            }

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax'])) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        } else {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }


    /**
     * Manages all models.
     */
    public function actionIndex()
    {
        $model = new AuthItem('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['AuthItem'])) {
            $model->attributes = $_GET['AuthItem'];
        }

        $this->render(
            'index',
            array(
                'model' => $model,
            )
        );
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = AuthItem::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'auth-item-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
