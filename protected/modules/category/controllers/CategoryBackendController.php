<?php

/**
 * CategoryBackendController контроллер для управления категориями в панели управления
 *
 * @author    yupe team <team@yupe.ru>
 * @link      http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package   yupe.modules.category.controllers
 * @version   0.6
 *
 */
class CategoryBackendController extends yupe\components\controllers\BackController
{
	/**
	 * Отображает категорию по указанному идентификатору
	 *
	 * @param integer $id Идинтификатор категорию для отображения
	 *
	 * @return void
	 */
	public function actionView($id)
	{
		$this->render('view', array('model' => $this->loadModel($id)));
	}

	/**
	 * Создает новую модель категории.
	 * Если создание прошло успешно - перенаправляет на просмотр.
	 *
	 * @return void
	 */
	public function actionCreate()
	{
		$model = new Category;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (($data = Yii::app()->getRequest()->getPost('Category')) !== null) {

			$model->setAttributes($data);

			if ($model->parent_id) {
				$result = $model->appendTo($this->loadModel($model->parent_id));
			} else {
				$result = $model->saveNode();
			}

			if ($result) {

				Yii::app()->user->setFlash(
					YFlashMessages::SUCCESS_MESSAGE,
					Yii::t('CategoryModule.category', 'Record was created!')
				);

				$this->redirect(
					(array)Yii::app()->getRequest()->getPost(
						'submit-type',
						array('create')
					)
				);
			}
		}

		$languages = $this->yupe->getLanguagesList();

		//если добавляем перевод
		$id = (int)Yii::app()->getRequest()->getQuery('id');
		$lang = Yii::app()->getRequest()->getQuery('lang');

		if (!empty($id) && !empty($lang)) {
			$category = Category::model()->findByPk($id);

			if (null === $category) {
				Yii::app()->user->setFlash(
					YFlashMessages::ERROR_MESSAGE,
					Yii::t('CategoryModule.category', 'Targeting category was not found!')
				);
				$this->redirect(array('create'));
			}

			if (!array_key_exists($lang, $languages)) {
				Yii::app()->user->setFlash(
					YFlashMessages::ERROR_MESSAGE,
					Yii::t('CategoryModule.category', 'Language was not found!')
				);

				$this->redirect(array('create'));
			}

			Yii::app()->user->setFlash(
				YFlashMessages::SUCCESS_MESSAGE,
				Yii::t(
					'CategoryModule.category',
					'You are adding translate in to {lang}!',
					array(
						'{lang}' => $languages[$lang]
					)
				)
			);

			$model->lang = $lang;
			$model->alias = $category->alias;
			$model->parent_id = $category->parent_id;
			$model->name = $category->name;
		} else {
			$model->lang = Yii::app()->language;
		}

		$this->render('create', array('model' => $model, 'languages' => $languages));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param integer $id the ID of the model to be updated
	 *
	 * @return void
	 */
	public function actionUpdate($id)
	{
		// Указан ID новости страницы, редактируем только ее
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (($data = Yii::app()->getRequest()->getPost('Category')) !== null) {
			$old_parent_id = $model->parent_id;
			$model->setAttributes(Yii::app()->getRequest()->getPost('Category'));

			if (empty($model->parent_id) && !$model->isRoot()) {
				$result = $model->moveAsRoot();
			} elseif ($model->parent_id && $old_parent_id != $model->parent_id) {
				$result = $model->moveAsLast($this->loadModel($model->parent_id));
			} else {
				$result = $model->saveNode();
			}

			if ($result) {

				Yii::app()->user->setFlash(
					YFlashMessages::SUCCESS_MESSAGE,
					Yii::t('CategoryModule.category', 'Category was changed!')
				);

				$this->redirect(
					(array)Yii::app()->getRequest()->getPost(
						'submit-type',
						array(
							'update',
							'id' => $model->id,
						)
					)
				);
			}
		}

		// найти по alias страницы на других языках
		$langModels = Category::model()->findAll(
			'alias = :alias AND id != :id',
			array(
				':alias' => $model->alias,
				':id'    => $model->id
			)
		);

		$this->render(
			'update',
			array(
				'model'      => $model,
				'langModels' => CHtml::listData($langModels, 'lang', 'id'),
				'languages'  => $this->yupe->getLanguagesList()
			)
		);
	}

	/**
	 * Удаяет модель категории из базы.
	 * Если удаление прошло успешно - возвращется в index
	 *
	 * @param integer $id идентификатор категории, который нужно удалить
	 *
	 * @return void
	 *
	 * @throws CHttpException
	 */
	public function actionDelete($id)
	{
		if (Yii::app()->getRequest()->getIsPostRequest()) {

			$transaction = Yii::app()->db->beginTransaction();

			try {
				// поддерживаем удаление только из POST-запроса
				$this->loadModel($id)->deleteNode();
				// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser

				$transaction->commit();

				if (!isset($_GET['ajax'])) {
					$this->redirect(
						(array)Yii::app()->getRequest()->getPost('returnUrl', 'index')
					);
				}
			} catch (Exception $e) {
				$transaction->rollback();

				Yii::log($e->__toString(), CLogger::LEVEL_ERROR);
			}

		} else {
			throw new CHttpException(
				400,
				Yii::t('CategoryModule.category', 'Bad request. Please don\'t use similar requests anymore')
			);
		}
	}

	/**
	 * Управление категориями.
	 *
	 * @return void
	 */
	public function actionIndex()
	{
		$model = new Category('search');
		$model->unsetAttributes(); // clear any default values

		if (isset($_GET['Category'])) {
			$model->attributes = $_GET['Category'];
		}

		$this->render('index', array('model' => $model));
	}

	/**
	 * Возвращает модель по указанному идентификатору
	 * Если модель не будет найдена - возникнет HTTP-исключение.
	 *
	 * @param integer идентификатор нужной модели
	 *
	 * @return Category $model
	 *
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Category::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, Yii::t('CategoryModule.category', 'Page was not found!'));
		}
		return $model;
	}

	/**
	 * Производит AJAX-валидацию
	 *
	 * @param Category модель, которую необходимо валидировать
	 *
	 * @return void
	 */
	protected function performAjaxValidation(Category $model)
	{
		if (Yii::app()->getRequest()->getIsAjaxRequest() && Yii::app()->getRequest()->getPost('ajax') === 'category-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionSort()
	{
		$id = (int)Yii::app()->getRequest()->getQuery('id');
		$direction = Yii::app()->getRequest()->getQuery('direction');

		if (!isset($direction, $id)) {
			throw new CHttpException(404, Yii::t('YupeModule.yupe', 'Page was not found!'));
		}

		$model = $this->loadModel($id);

		/* If root - we should change root attribute, else use nested sets functions */
		if ($model->isRoot()) {
			if ($direction === 'up') {
				$depends_id = Yii::app()->db->createCommand(
					'SELECT `id` FROM {{category_category}} WHERE `root` < :root AND `level` = 1 ORDER BY `root` DESC LIMIT 1'
				)->bindValue(
						':root',
						$model->root
					)->queryScalar();
			} else {
				$depends_id = Yii::app()->db->createCommand(
					'SELECT `id` FROM {{category_category}} WHERE `root` > :root AND `level` = 1 ORDER BY `root` ASC LIMIT 1'
				)->bindValue(
						':root',
						$model->root
					)->queryScalar();
			}

			if ($depends_id) {
				$model_depends = $this->loadModel($depends_id);

				$old_root = $model->root;
				$new_root = $model_depends->root;

				$models = array_merge($model->descendants()->findAll(), array($model));
				$models_depends = array_merge($model_depends->descendants()->findAll(), array($model_depends));

				foreach ($models as $m) {
					$m->root = $new_root;
					$m->saveNode();
				}

				foreach ($models_depends as $m) {
					$m->root = $old_root;
					$m->saveNode();
				}
			}
		} else {
			if ($direction === 'up') {
				$model_depends = $model->prev()->find();
				if (!empty($model_depends)) {
					$model->moveBefore($model_depends);
				}
			} else {
				$model_depends = $model->next()->find();;
				if (!empty($model_depends)) {
					$model->moveAfter($model_depends);
				}
			}
		}

		if (!Yii::app()->getRequest()->getIsAjaxRequest()) {
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
	}
}