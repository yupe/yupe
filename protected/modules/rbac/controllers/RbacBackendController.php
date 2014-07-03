<?php

class RbacBackendController extends yupe\components\controllers\BackController
{
    public function accessRules()
    {
        return array(
            array('allow',
                'roles' => array('admin'),
            ),
            array('allow',
                'actions' => array('assign'),
                'roles' => array('Rbac.RbacBackend.Assign'),
            ),
            array('allow',
                'actions' => array('create'),
                'roles' => array('Rbac.RbacBackend.Create'),
            ),
            array('allow',
                'actions' => array('delete'),
                'roles' => array('Rbac.RbacBackend.Delete'),
            ),
            array('allow',
                'actions' => array('import'),
                'roles' => array('Rbac.RbacBackend.Import'),
            ),
            array('allow',
                'actions' => array('index'),
                'roles' => array('Rbac.RbacBackend.Index'),
            ),
            array('allow',
                'actions' => array('inlineEdit'),
                'roles' => array('Rbac.RbacBackend.Update'),
            ),
            array('allow',
                'actions' => array('update'),
                'roles' => array('Rbac.RbacBackend.Update'),
            ),
            array('allow',
                'actions' => array('userList'),
                'roles' => array('Rbac.RbacBackend.Assign'),
            ),
            array('allow',
                'actions' => array('view'),
                'roles' => array('Rbac.RbacBackend.View'),
            ),
            array('deny',),
        );
    }

    public function actions()
    {
        return array(
            'inlineEdit' => array(
                'class' => 'yupe\components\actions\YInLineEditAction',
                'model' => 'AuthItem',
                'validAttributes' => array('description', 'type'),
            )
        );
    }

    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id),));
    }

    public function actionAssign($id)
    {
        $user = User::model()->findByPk((int)$id);

        if (!$user)
        {
            throw new CHttpException(404);
        }

        $items     = AuthItem::model()->findAll(array('order' => 'type DESC, description ASC'));
        $itemsData = CHtml::listData(AuthItemChild::model()->findAll(), 'child', 'parent');

        if (Yii::app()->request->isPostRequest)
        {
            $itemsArray  = CHtml::listData($items, 'name', 'description');
            $transaction = Yii::app()->db->beginTransaction();

            try
            {
                AuthAssignment::model()->deleteAll(
                    'userid = :userid',
                    array(
                        ':userid' => (int)$user->id
                    )
                );

                foreach ((array)$_POST['AuthItem'] as $op)
                {
                    if (!isset($itemsArray[$op]))
                    {
                        continue;
                    }

                    $model = new AuthAssignment();

                    $model->setAttributes(
                        array(
                            'userid' => $user->id,
                            'itemname' => $op
                        )
                    );

                    if (!$model->save())
                    {
                        throw new CDbException('При сохранении произошла ошибка!');
                    }
                }

                $transaction->commit();

                Yii::app()->user->setFlash(yupe\widgets\YFlashMessages::SUCCESS_MESSAGE, 'Данные обновлены!');

                $this->redirect(array('assign', 'id' => $user->id));
            } catch (Exception $e)
            {
                Yii::app()->user->setFlash(yupe\widgets\YFlashMessages::ERROR_MESSAGE, $e->getMessage());

                $transaction->rollback();
            }
        }

        $tree = array();
        /* @var $items AuthItem[] */
        foreach ($items as $item)
        {
            $itemTemplate = array(
                'text' => CHtml::label(
                    CHtml::checkBox(
                        'AuthItem[]',
                        Yii::app()->authManager->checkAccess($item->name, $user->id),
                        array('name' => 'operations', 'class' => 'root', 'value' => $item->name,)
                    ) .
                    $item->description . " ({$item->getType()})", null, array('class' => 'checkbox')
                )
            );

            if ((int)$item->type === AuthItem::TYPE_ROLE && !isset($tree[$item->name]))
            {
                $tree[$item->name] = $itemTemplate;
            }

            if ((int)$item->type === AuthItem::TYPE_TASK)
            {
                if (isset($itemsData[$item->name]) && $itemsData[$item->name])
                {
                    $tree[$itemsData[$item->name]]['children'][$item->name] = $itemTemplate;
                }
                else
                {
                    $tree[$item->name] = $itemTemplate;
                }
            }

            if ((int)$item->type === AuthItem::TYPE_OPERATION)
            {
                if (isset($itemsData[$item->name]) && $itemsData[$item->name])
                {
                    $parent = $itemsData[$item->name];

                    if (isset($itemsData[$parent]) && $itemsData[$parent])
                    {
                        $tree[$itemsData[$parent]]['children'][$itemsData[$item->name]]['children'][$item->name] = $itemTemplate;
                    }
                    else
                    {
                        $tree[$itemsData[$item->name]]['children'][$item->name] = $itemTemplate;
                    }
                }
                else
                {
                    $tree[$item->name] = $itemTemplate;
                }
            }
        }

        $this->render('assign', array('tree' => $tree, 'model' => $user));
    }

    public function actionCreate()
    {
        $model = new AuthItem();

        $operationsList = $tasksList = $rolesList = array();

        $items = AuthItem::model()->findAll();
        foreach ($items as $item)
        {
            switch ($item->type)
            {
                case AuthItem::TYPE_OPERATION:
                    $operationsList[$item->name] = $item->description . " ({$item->name})";
                    break;
                case AuthItem::TYPE_TASK:
                    $tasksList[$item->name] = $item->description . " ({$item->name})";
                    break;
                case AuthItem::TYPE_ROLE:
                    $rolesList[$item->name] = $item->description . " ({$item->name})";
                    break;
            }
        }

        if (Yii::app()->request->isPostRequest && isset($_POST['AuthItem']))
        {
            $transaction = Yii::app()->db->beginTransaction();
            try
            {
                $model->attributes = Yii::app()->request->getPost('AuthItem');
                if ($model->save())
                {
                    $children = array();
                    if ($model->type == AuthItem::TYPE_TASK)
                    {
                        $children = Yii::app()->request->getPost('operations', array());
                    }
                    else if ($model->type == AuthItem::TYPE_TASK)
                    {
                        $children = array_merge(
                            Yii::app()->request->getPost('operations', array()),
                            Yii::app()->request->getPost('tasks', array())
                        );
                    }
                    elseif ($model->type == AuthItem::TYPE_ROLE)
                    {
                        $children = array_merge(
                            Yii::app()->request->getPost('operations', array()),
                            Yii::app()->request->getPost('tasks', array()),
                            Yii::app()->request->getPost('roles', array())
                        );
                    }

                    if (!empty($children))
                    {
                        foreach ($children as $name)
                        {
                            if ($name == $model->name)
                            {
                                continue;
                            }

                            $child = new AuthItemChild;
                            $child->setAttributes(
                                array(
                                    'parent' => $model->name,
                                    'child' => $name
                                )
                            );

                            if (!$child->save())
                            {
                                throw new CDbException('Ошибка при сохранении связанных объектов!');
                            }
                        }
                    }
                    $transaction->commit();

                    Yii::app()->user->setFlash('success', 'Действие добавлено!');
                    $this->redirect(array('view', 'id' => $model->name));
                }
            } catch (Exception $e)
            {
                Yii::app()->user->setFlash('error', $e->getMessage());
                $transaction->rollback();
            }
        }

        $this->render(
            'create',
            array(
                'model' => $model,
                'operations' => $operationsList,
                'tasks' => $tasksList,
                'roles' => $rolesList,
            )
        );
    }

    public function actionUpdate($id)
    {
        /* @var $model AuthItem */
        $model = AuthItem::model()->with('parents.parentItem')->findByPk($id);

        $operationsList = $tasksList = $rolesList = $checkedList = array();

        $items = AuthItem::model()->findAll();
        foreach ($items as $item)
        {
            if ($item->name == $id)
            {
                continue;
            }
            switch ($item->type)
            {
                case AuthItem::TYPE_OPERATION:
                    $operationsList[$item->name] = $item->description . " ({$item->name})";
                    break;
                case AuthItem::TYPE_TASK:
                    $tasksList[$item->name] = $item->description . " ({$item->name})";
                    break;
                case AuthItem::TYPE_ROLE:
                    $rolesList[$item->name] = $item->description . " ({$item->name})";
                    break;
            }
        }

        foreach ($model->children as $item)
        {
            $checkedList[$item->childItem->name] = $item->childItem->description . " ({$item->childItem->name})";
        }

        if (Yii::app()->request->isPostRequest && isset($_POST['AuthItem']))
        {
            $transaction = Yii::app()->db->beginTransaction();
            try
            {
                $model->attributes = $_POST['AuthItem'];
                if ($model->save())
                {
                    $items = array();
                    /* роли могут включать в себя роли, задачи, операции, задачи - задачи и операции, операции - операции*/
                    switch ($model->type)
                    {
                        case AuthItem::TYPE_ROLE:
                            $items = array_merge($items, Yii::app()->request->getPost('roles', array()));
                        case AuthItem::TYPE_TASK:
                            $items = array_merge($items, Yii::app()->request->getPost('tasks', array()));
                        case AuthItem::TYPE_OPERATION:
                            $items = array_merge($items, Yii::app()->request->getPost('operations', array()));
                            break;
                    }

                    AuthItemChild::model()->deleteAll(
                        'parent = :parent',
                        array(
                            ':parent' => $model->name
                        )
                    );

                    foreach ($items as $name)
                    {
                        $child = new AuthItemChild;
                        $child->setAttributes(
                            array(
                                'parent' => $model->name,
                                'child' => $name
                            )
                        );

                        if (!$child->save())
                        {
                            throw new CException('Ошибка при сохранении связанных объектов!');
                        }
                    }

                    $transaction->commit();

                    Yii::app()->user->setFlash('success', 'Действие изменено!');
                    $this->redirect(array('update', 'id' => $model->name));
                }
            } catch (Exception $e)
            {
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
                'roles' => $rolesList,
                'checkedList' => $checkedList,
            )
        );
    }

    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest)
        {
            try
            {
                $this->loadModel($id)->delete();
            } catch (CDbException $e)
            {
                throw new CHttpException(500, 'Невозможно удалить запись!');
            }

            if (!isset($_GET['ajax']))
            {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }
        }
        else
        {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
    }

    public function actionIndex()
    {
        $model = new AuthItem('search');
        $model->unsetAttributes();
        if (isset($_GET['AuthItem']))
        {
            $model->attributes = $_GET['AuthItem'];
        }

        $this->render('index', array('model' => $model,));
    }

    public function actionUserList()
    {
        $model = new User('search');
        $model->unsetAttributes();
        $model->setAttributes(Yii::app()->getRequest()->getParam('User', array()));
        $this->render('userList', array('model' => $model));
    }

    /**
     * Разворачивает дерево до списка
     * @param $rules - Дерево правил
     * @param null $parent
     * @return array - Список правил
     */
    private function getRulesList($rules, $parent = null)
    {
        $items = array();
        foreach ($rules as $rule)
        {
            $items[] = array(
                'name' => $rule['name'],
                'description' => $rule['description'],
                'type' => $rule['type'],
                'bizrule' => isset($rule['bizrule']) ? $rule['bizrule'] : null,
                'parent' => $parent ? $parent['name'] : '',
            );
            if (isset($rule['items']) && is_array($rule['items']))
            {
                $items = array_merge($items, $this->getRulesList($rule['items'], $rule));
            }
        }
        return $items;
    }

    private function getRulesParentsAndChildren($rulesList)
    {
        $items = array();
        foreach ($rulesList as $rule)
        {
            if ($rule['parent'])
            {
                $items[] = array(
                    'parent' => $rule['parent'],
                    'child' => $rule['name'],
                );
            }
        }
        return $items;
    }

    public function actionImport()
    {
        $modulesList = array();
        $modules     = array();
        foreach (Yii::app()->getModules() as $key => $value)
        {
            $key    = strtolower($key);
            $module = Yii::app()->getModule($key);
            if (($module !== null))
            {
                if ($module instanceof \yupe\components\WebModule)
                {
                    $modulesList[$key] = $module->getName() . " <span class='muted'>[{$key}]</span>";
                    $modules[$key]     = $module;
                }
            }
        }
        if (Yii::app()->request->isPostRequest)
        {
            foreach ((array)$_POST['modules'] as $moduleName)
            {
                if (isset($modules[$moduleName]))
                {
                    /* @var $module \yupe\components\WebModule */
                    $module = $modules[$moduleName];
                    $rules  = $module->getAuthItems();

                    // 1 - получить все элементы из дерева
                    $items           = $this->getRulesList($rules);
                    $parentsChildren = $this->getRulesParentsAndChildren($items);

                    // обновляем
                    foreach ($items as $item)
                    {
                        $model = AuthItem::model()->findByPk($item['name']);
                        if (!$model)
                        {
                            $model = new AuthItem();
                        }
                        $model->attributes = $item;
                        $model->save();
                    }

                    // удаляем удаленные из модуля
                    // оставшиеся
                    $availableItems = array_map(function ($x)
                    {
                        return $x['name'];
                    }, $items);

                    /* удаляем правила */
                    $criteria = new CDbCriteria();
                    $criteria->addCondition('name like :rule');
                    $criteria->params = array(':rule' => ucfirst($moduleName) . '.%');
                    $criteria->addNotInCondition('name', $availableItems);

                    AuthItem::model()->deleteAll($criteria);

                    /* создаем связи */
                    foreach ($parentsChildren as $pair)
                    {
                        $model = AuthItemChild::model()->findByPk(array('parent' => $pair['parent'], 'child' => $pair['child']));
                        if (!$model)
                        {
                            $model             = new AuthItemChild();
                            $model->attributes = $pair;
                            $model->save();
                        }
                    }
                }
            }

            Yii::app()->user->setFlash('success', 'Правила импортированы!');
            $this->redirect(array('import'));
        }
        $this->render('import', array('modules' => $modulesList));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param $id integer The ID of the model to be loaded
     * @return AuthItem
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = AuthItem::model()->findByPk($id);
        if ($model === null)
        {
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'auth-item-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
