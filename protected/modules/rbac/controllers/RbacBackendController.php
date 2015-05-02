<?php

class RbacBackendController extends yupe\components\controllers\BackController
{
    public function accessRules()
    {
        return [
            ['allow', 'roles' => [AuthItem::ROLE_ADMIN]],
            ['allow', 'actions' => ['index'], 'roles' => ['Rbac.RbacBackend.Index']],
            ['allow', 'actions' => ['view'], 'roles' => ['Rbac.RbacBackend.View']],
            ['allow', 'actions' => ['create'], 'roles' => ['Rbac.RbacBackend.Create']],
            ['allow', 'actions' => ['update', 'inlineEdit'], 'roles' => ['Rbac.RbacBackend.Update']],
            ['allow', 'actions' => ['delete', 'multiaction'], 'roles' => ['Rbac.RbacBackend.Delete']],
            ['allow', 'actions' => ['assign', 'userList'], 'roles' => ['Rbac.RbacBackend.Assign']],
            ['allow', 'actions' => ['import'], 'roles' => ['Rbac.RbacBackend.Import']],
            ['deny',]
        ];
    }

    public function actions()
    {
        return [
            'inlineEdit' => [
                'class'           => 'yupe\components\actions\YInLineEditAction',
                'model'           => 'AuthItem',
                'validAttributes' => ['description', 'type'],
            ]
        ];
    }

    public function actionView($id)
    {
        $this->render('view', ['model' => $this->loadModel($id),]);
    }

    public function actionAssign($id = null)
    {
        $user = User::model()->findByPk((int)$id);
        if (!$user) {
            $this->redirect(['userList']);
        }

        if (Yii::app()->getRequest()->isPostRequest) {
            /* получение названий ролей, которые есть в базе */
            $existingRoles = Yii::app()->db->createCommand('SELECT name FROM {{user_user_auth_item}}')->queryColumn();

            $transaction = Yii::app()->db->beginTransaction();

            try {
                AuthAssignment::model()->deleteAll('userid = :userid', [':userid' => (int)$user->id]);
                // убираем дубликаты и несуществующие роли
                $roles = array_intersect(
                    array_unique((array)Yii::app()->getRequest()->getPost('AuthItem')),
                    $existingRoles
                );
                foreach ($roles as $op) {
                    $model = new AuthAssignment();
                    $model->setAttributes(
                        [
                            'userid'   => $user->id,
                            'itemname' => $op
                        ]
                    );

                    if (!$model->save()) {
                        throw new CDbException(Yii::t(
                            'RbacModule.rbac',
                            'There is an error occurred when saving data!'
                        ));
                    }
                }

                $transaction->commit();

                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('RbacModule.rbac', 'Data was updated!')
                );

                /*сброс кэша меню*/
                Yii::app()->getCache()->delete('YAdminPanel::' . $id . '::' . Yii::app()->getLanguage());

                /*сброс кеша прав*/
                Yii::app()->getCache()->delete(Yii::app()->getUser()->rbacCacheNameSpace . $id);

                $this->redirect(['assign', 'id' => $user->id]);
            } catch (Exception $e) {

                Yii::app()->getUser()->setFlash(yupe\widgets\YFlashMessages::ERROR_MESSAGE, $e->getMessage());
                $transaction->rollback();
            }
        }

        $rbacTree = new RbacTree($user);
        $tree = $rbacTree->getTreeRoles();
        $this->render('assign', ['tree' => $tree, 'model' => $user]);
    }

    public function actionCreate()
    {
        $model = new AuthItem();

        if (Yii::app()->getRequest()->isPostRequest && isset($_POST['AuthItem'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = Yii::app()->getRequest()->getPost('AuthItem');
                if ($model->save()) {
                    $this->updateAuthItemChildren($model);

                    $transaction->commit();

                    Yii::app()->getUser()->setFlash(
                        yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t('RbacModule.rbac', 'The item is added!')
                    );
                    $this->redirect(['view', 'id' => $model->name]);
                }
            } catch (Exception $e) {
                Yii::app()->getUser()->setFlash('error', $e->getMessage());
                $transaction->rollback();
            }
        }

        $rbacTree = new RbacTree();
        $this->render(
            'create',
            [
                'model'      => $model,
                'operations' => $rbacTree->getItemsList(AuthItem::TYPE_OPERATION),
                'tasks'      => $rbacTree->getItemsList(AuthItem::TYPE_TASK),
                'roles'      => $rbacTree->getItemsList(AuthItem::TYPE_ROLE),
            ]
        );
    }

    private function updateAuthItemChildren(AuthItem $item)
    {
        $criteria = new CDbCriteria();
        // для операций доступны только операции, для задач - операции и задачи, для ролей - роли, задачи и операции
        $criteria->addInCondition(
            'type',
            array_slice([AuthItem::TYPE_OPERATION, AuthItem::TYPE_TASK, AuthItem::TYPE_ROLE], 0, $item->type + 1)
        );
        // не может наследовать себя
        $criteria->addNotInCondition('name', [$item->name]);

        $availableChildren = AuthItem::model()->findAll($criteria);
        // названия ролей, которые могут бы потомками
        $availableChildrenName = array_keys(CHtml::listData($availableChildren, 'name', 'description'));
        // уберем те, которые не могут быть потомками
        $children = array_intersect(
            Yii::app()->getRequest()->getPost('ChildAuthItems', []),
            $availableChildrenName
        );

        AuthItemChild::model()->deleteAll('parent = :parent', [':parent' => $item->name]);

        foreach ($children as $name) {
            $child = new AuthItemChild();
            $child->setAttributes(
                [
                    'parent' => $item->name,
                    'child'  => $name
                ]
            );

            if (!$child->save()) {
                throw new CDbException(Yii::t('RbacModule.rbac', 'There is an error occurred when saving data!'));
            }
        }
    }

    public function actionUpdate($id)
    {
        /* @var $model AuthItem */
        $model = AuthItem::model()->findByPk($id);

        $checkedList = [];
        foreach ($model->children as $item) {
            $checkedList[$item->childItem->name] = true;
        }

        if (Yii::app()->getRequest()->isPostRequest && isset($_POST['AuthItem'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['AuthItem'];
                if ($model->save()) {
                    $this->updateAuthItemChildren($model);

                    $transaction->commit();

                    Yii::app()->getUser()->setFlash(
                        yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t('RbacModule.rbac', 'The item is changed!')
                    );
                    $this->redirect(['update', 'id' => $model->name]);
                }
            } catch (Exception $e) {
                Yii::app()->getUser()->setFlash('error', $e->getMessage());
                $transaction->rollback();
            }
        }

        $rbacTree = new RbacTree();
        $this->render(
            'update',
            [
                'model'       => $model,
                'operations'  => $rbacTree->getItemsList(AuthItem::TYPE_OPERATION),
                'tasks'       => $rbacTree->getItemsList(AuthItem::TYPE_TASK),
                'roles'       => $rbacTree->getItemsList(AuthItem::TYPE_ROLE),
                'checkedList' => $checkedList,

            ]
        );
    }

    public function actionDelete($id)
    {
        if (!Yii::app()->getRequest()->isPostRequest) {
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
        }
        try {
            $this->loadModel($id)->delete();
        } catch (CDbException $e) {
            throw new CHttpException(Yii::t('RbacModule.rbac', 'There is an error occurred when deleting data!'));
        }

        if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['index']);
        }
    }

    public function actionIndex()
    {
        $model = new AuthItem('search');
        $model->unsetAttributes();
        if (isset($_GET['AuthItem'])) {
            $model->attributes = $_GET['AuthItem'];
        }

        $this->render('index', ['model' => $model,]);
    }

    public function actionUserList()
    {
        $model = new User('search');
        $model->unsetAttributes();
        $model->setAttributes(Yii::app()->getRequest()->getParam('User', []));
        $this->render('userList', ['model' => $model]);
    }

    /**
     * Разворачивает дерево до списка
     * @param $rules - Дерево правил
     * @param  null $parent
     * @return array - Список правил
     */
    private function getRulesList($rules, $parent = null)
    {
        $items = [];
        foreach ($rules as $rule) {
            $items[] = [
                'name'        => $rule['name'],
                'description' => $rule['description'],
                'type'        => $rule['type'],
                'bizrule'     => isset($rule['bizrule']) ? $rule['bizrule'] : null,
                'parent'      => $parent ? $parent['name'] : '',
            ];
            if (isset($rule['items']) && is_array($rule['items'])) {
                $items = array_merge($items, $this->getRulesList($rule['items'], $rule));
            }
        }

        return $items;
    }

    private function getRulesParentsAndChildren($rulesList)
    {
        $items = [];
        foreach ($rulesList as $rule) {
            if ($rule['parent']) {
                $items[] = [
                    'parent' => $rule['parent'],
                    'child'  => $rule['name'],
                ];
            }
        }

        return $items;
    }

    public function actionImport()
    {
        $modulesList = [];
        $modules = [];
        foreach (Yii::app()->getModules() as $key => $value) {
            $key = strtolower($key);
            $module = Yii::app()->getModule($key);
            if ($module instanceof \yupe\components\WebModule) {
                $modulesList[$key] = $module->getName();
                $modules[$key] = $module;
            }
        }
        if (Yii::app()->getRequest()->isPostRequest) {
            $importModules = array_intersect(
                Yii::app()->getRequest()->getPost('modules', []),
                array_keys($modules)
            );
            foreach ($importModules as $moduleName) {
                /* @var $module \yupe\components\WebModule */
                $module = $modules[$moduleName];
                $rules = $module->getAuthItems();

                // 1 - получить все элементы из дерева
                $items = $this->getRulesList($rules);
                $parentsChildren = $this->getRulesParentsAndChildren($items);

                // обновляем
                foreach ($items as $item) {
                    $model = AuthItem::model()->findByPk($item['name']);
                    if (!$model) {
                        $model = new AuthItem();
                    }
                    $model->attributes = $item;
                    $model->save();
                }

                // удаляем удаленные из модуля
                // оставшиеся
                $availableItems = array_map(
                    function ($x) {
                        return $x['name'];
                    },
                    $items
                );

                /* удаляем правила */
                $criteria = new CDbCriteria();
                $criteria->addCondition('name like :rule');
                $criteria->params = [':rule' => ucfirst($moduleName) . '.%'];
                $criteria->addNotInCondition('name', $availableItems);

                AuthItem::model()->deleteAll($criteria);

                /* создаем связи */
                foreach ($parentsChildren as $pair) {
                    $model = AuthItemChild::model()->findByPk(
                        ['parent' => $pair['parent'], 'child' => $pair['child']]
                    );
                    if (!$model) {
                        $model = new AuthItemChild();
                        $model->attributes = $pair;
                        $model->save();
                    }
                }
            }

            Yii::app()->getUser()->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t('RbacModule.rbac', 'Items successfully imported!')
            );
            $this->redirect(['import']);
        }
        $this->render('import', ['modules' => $modulesList]);
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
        if ($model === null) {
            throw new CHttpException(404, Yii::t('RbacModule.rbac', 'was not found'));
        }

        return $model;
    }
}
