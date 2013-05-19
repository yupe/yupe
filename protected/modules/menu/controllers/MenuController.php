<?php

class MenuController extends YBackController
{
    /**
     * Отображает меню по указанному идентификатору
     * @param integer $id Идинтификатор меню для отображения
     */
    public function actionView($id)
    {
        $model = $this->loadModel($id);

        $code = "<?php \$this->widget(
    'application.modules.menu.widgets.MenuWidget', array(
        'name'         => '{$model->code}',
        'params'       => array('hideEmptyItems' => true),
        'layoutParams' => array(
            'htmlOptions' => array(
                'class' => 'jqueryslidemenu',
                'id'    => 'myslidemenu',
            )
        ),
    )
); ?>";

        $highlighter = new CTextHighlighter;
        $highlighter->language = 'PHP';
        $example = $highlighter->highlight($code); 

        $this->render('view', array(
            'model'   => $model,
            'example' => $example,
        ));
    }

    /**
     * Создает новую модель меню.
     * Если создание прошло успешно - перенаправляет на просмотр.
     */
    public function actionCreate()
    {
        $model = new Menu;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Menu']))
        {
            $model->attributes = $_POST['Menu'];

            if ($model->save())
            {
                $this->redirect(
                    (array) Yii::app()->request->getPost(
                        'submit-type', array('create')
                    )
                );
            }
        }
        $this->render('create', array('model' => $model));
    }

    /**
     * Редактирование меню.
     * @param integer $id Идинтификатор меню для редактирования
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Menu']))
        {
            $model->attributes = $_POST['Menu'];

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
     * Удаляет модель меню из базы.
     * Если удаление прошло успешно - возвращется в index
     * @param integer $id идентификатор меню, который нужно удалить
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        }
        else
            throw new CHttpException(400, Yii::t('MenuModule.menu', 'Неверный запрос. Пожалуйста, больше не повторяйте такие запросы!'));
    }   

    /**
     * Управление блогами.
     */
    public function actionIndex()
    {
        $model = new Menu('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Menu']))
            $model->attributes = $_GET['Menu'];
        $this->render('index', array('model' => $model));
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     * @param integer идентификатор нужной модели
     */
    public function loadModel($id)
    {
        $model = Menu::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, Yii::t('MenuModule.menu', 'Запрошенная страница не найдена!'));
        return $model;
    }

    /**
     * Производит AJAX-валидацию
     * @param CModel модель, которую необходимо валидировать
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'menu-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
