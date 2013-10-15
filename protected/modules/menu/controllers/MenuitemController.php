<?php
/**
 * MenuitemController контроллер для управления пунктами меню в панели управления
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.menu.controllers
 * @since 0.1
 *
 */
class MenuitemController extends yupe\components\controllers\BackController
{


    public function actionGetjsonitems()
    {

        if(!Yii::app()->getRequest()->getIsPostRequest() || !Yii::app()->getRequest()->getIsAjaxRequest()){
            throw new CHttpException(404);
        }

        $menuId = (int)Yii::app()->getRequest()->getPost('menuId');

        if(!$menuId){
            throw new CHttpException(404);
        }

        $items = MenuItem::model()->public()->findAll(array(
            'condition' => 'menu_id = :menu_id',
            'order'  => 'title DESC',
            'params' => array(
                ':menu_id' => $menuId
            )
        ));

        Yii::app()->ajax->success(CHtml::listData($items,'id','title'));
    }

    /**
     * Отображает пункт меню по указанному идентификатору
     * @param integer $id Идинтификатор меню для отображения
     */
    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
    }

    /**
     * Создает новую модель пунта меню.
     * Если создание прошло успешно - перенаправляет на просмотр.
     */
    public function actionCreate()
    {
        $model = new MenuItem;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if ($mid = (int) Yii::app()->getRequest()->getQuery('mid'))
            $model->menu_id = $mid;

        if (isset($_POST['MenuItem']))
        {
            $model->attributes = $_POST['MenuItem'];

            if ($model->save())
            {
                $this->redirect(
                    (array) Yii::app()->getRequest()->getPost(
                        'submit-type', array('create')
                    )
                );
            }
        }

        $criteria = new CDbCriteria;
        $criteria->select = new CDbExpression('MAX(sort) as sort');
        $max = $model->find($criteria);

        $model->sort = $max->sort + 1; // Set sort in Adding Form as ma x+ 1

        $this->render('create', array('model' => $model));
    }

    /**
     * Редактирование пункта меню.
     * @param integer $id Идинтификатор пункта меню для редактирования
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['MenuItem']))
        {
            $model->attributes = $_POST['MenuItem'];

            if ($model->save())
            {
                 if (!isset($_POST['submit-type']))
                    $this->redirect(array('update', 'id' => $model->id));
                 else
                    $this->redirect(array($_POST['submit-type']));
            }
        }
        $this->render('update', array('model' => $model));
    }

    /**
     * Удаляет модель пункта меню из базы.
     * Если удаление прошло успешно - возвращется в index
     * @param integer $id идентификатор пункта меню, который нужно удалить
     */
    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest())
        {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, Yii::t('MenuModule.menu', 'Bad request. Please don\'t try similar requests anymore!'));
    }

    /**
     * Управление пунктами меню.
     */
    public function actionIndex()
    {
        $model = new MenuItem('search');
        
        $model->unsetAttributes();  // clear any default values
        
        if (($data = Yii::app()->getRequest()->getParam('MenuItem')) !== null) {
            $model->setAttributes($data);
        }
        
        $this->render('index', array('model' => $model));
    }

    /**
     * Обновление дерева пунктов меню в завимости от родителя.
     */
    public function actionDynamicParent()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest() && isset($_POST['MenuItem']))
        {
            $model = new MenuItem('search');
            $model->attributes = $_POST['MenuItem'];
            if ($model->menu_id)
            {
                if (isset($_GET['id']))
                    $model->id = $_GET['id'];
                $data = $model->parentTree;
                foreach ($data as $value => $name)
                    echo CHtml::tag('option', array('value' => $value), $name, true);
            }
        }
        Yii::app()->end();
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     * @param integer идентификатор нужной модели
     */
    public function loadModel($id)
    {
        $model = MenuItem::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, Yii::t('MenuModule.menu', 'Page was not found!'));
        return $model;
    }

    /**
     * Производит AJAX-валидацию
     * @param CModel модель, которую необходимо валидировать
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'menuitem-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}