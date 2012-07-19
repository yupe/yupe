<?php

class CategoryController extends YBackController
{
	/**
	 * Отображает категорию по указанному идентификатору
	 * @param integer $id Идинтификатор категорию для отображения
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Создает новую модель категории.
	 * Если создание прошло успешно - перенаправляет на просмотр.
	 */
	public function actionCreate()
	{
		$model=new Category;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Category']))
		{
			$model->attributes=$_POST['Category'];

			if($model->save())
                        {
                            Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE,Yii::t('yupe','Запись добавлена!'));

			    $this->redirect(array('view','id'=>$model->id));
                        }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Редактирование категории.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Category']))
		{
			$model->attributes=$_POST['Category'];

			if($model->save())
                        {
                            Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE,Yii::t('yupe','Запись обновлена!'));

			    $this->redirect(array('update','id' => $model->id));
                        }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Удаяет модель категории из базы.
	 * Если удаление прошло успешно - возвращется в index
	 * @param integer $id идентификатор категории, который нужно удалить
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// поддерживаем удаление только из POST-запроса
			$this->loadModel($id)->delete();

			// если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('штвуч'));
		}
		else
			throw new CHttpException(400,'Неверный запрос. Пожалуйста, больше не повторяйте такие запросы');
	}
	/**
	 * Управление категориями.
	 */
	public function actionIndex()
	{
		$model=new Category('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Category']))
			$model->attributes=$_GET['Category'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Возвращает модель по указанному идентификатору
	 * Если модель не будет найдена - возникнет HTTP-исключение.
	 * @param integer идентификатор нужной модели
	 */
	public function loadModel($id)
	{
		$model=Category::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'Запрошенная страница не найдена.');
		return $model;
	}

	/**
	 * Производит AJAX-валидацию
	 * @param CModel модель, которую необходимо валидировать
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='category-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
