<?php
/**
 * This is the template for generating a controller class file for CRUD feature.
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php echo "<?php\n"; ?>

class <?php echo $this->controllerClass; ?> extends <?php echo $this->baseControllerClass."\n"; ?>
{
	/**
	 * @var string лайаут по-умолчанию для генерации views. По-умолчанию задан в '//layouts/column2', что означает
	 * использование двухколоночной верстки. Смотрите файл 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // проверка прав доступа для CRUD операций
		);
	}

	/**
	 * Задает правила доступа к контроллеру
	 * Этот метод используется фитром 'accessControl'
	 * @return array набор правил доступа
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','create','update'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Отображает <?=$this->vin;?> по указанному идентификатору
	 * @param integer $id Идинтификатор <?=$this->vin;?> для отображения
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Создает новую модель <?=$this->rod;?>.
	 * Если создание прошло успешно - перенаправляет на просмотр.
	 */
	public function actionCreate()
	{
		$model=new <?php echo $this->modelClass; ?>;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['<?php echo $this->modelClass; ?>']))
		{
			$model->attributes=$_POST['<?php echo $this->modelClass; ?>'];
			if($model->save())
				$this->redirect(array('view','id'=>$model-><?php echo $this->tableSchema->primaryKey; ?>));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Редактирование <?=$this->rod;?>.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['<?php echo $this->modelClass; ?>']))
		{
			$model->attributes=$_POST['<?php echo $this->modelClass; ?>'];
			if($model->save())
				$this->redirect('index');
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Удаяет модель <?=$this->rod;?> из базы.
	 * Если удаление прошло успешно - возвращется в index
	 * @param integer $id идентификатор <?=$this->rod;?>, который нужно удалить
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
	 * Управление <?=$this->mtvor;?>.
	 */
	public function actionIndex()
	{
		$model=new <?php echo $this->modelClass; ?>('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['<?php echo $this->modelClass; ?>']))
			$model->attributes=$_GET['<?php echo $this->modelClass; ?>'];

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
		$model=<?php echo $this->modelClass; ?>::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='<?php echo $this->class2id($this->modelClass); ?>-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
