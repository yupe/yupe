<?php
/**
* Rights assignment controller class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.9.1
*/
class AssignmentController extends RController
{
	/**
	* @property RAuthorizer
	*/
	private $_authorizer;

	/**
	* Initializes the controller.
	*/
	public function init()
	{
		$this->_authorizer = $this->module->getAuthorizer();
		$this->layout = $this->module->layout;
		$this->defaultAction = 'view';

		// Register the scripts
		$this->module->registerScripts();
	}

	/**
	* @return array action filters
	*/
	public function filters()
	{
		return array('accessControl');
	}

	/**
	* Specifies the access control rules.
	* This method is used by the 'accessControl' filter.
	* @return array access control rules
	*/
	public function accessRules()
	{
		return array(
			array('allow', // Allow superusers to access Rights
				'actions'=>array(
					'view',
					'user',
					'revoke',
				),
				'users'=>$this->_authorizer->getSuperusers(),
			),
			array('deny', // Deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	* Displays an overview of the users and their assignments.
	*/
	public function actionView()
	{
		// Create a data provider for listing the users
		$dataProvider = new RAssignmentDataProvider(array(
			'pagination'=>array(
				'pageSize'=>50,
			),
		));

		// Render the view
		$this->render('view', array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	* Displays the authorization assignments for an user.
	*/
	public function actionUser()
	{
		// Create the user model and attach the required behavior
		$userClass = $this->module->userClass;
		$model = CActiveRecord::model($userClass)->findByPk($_GET['id']);
		$this->_authorizer->attachUserBehavior($model);

		$assignedItems = $this->_authorizer->getAuthItems(null, $model->getId());
		$assignments = array_keys($assignedItems);

		// Make sure we have items to be selected
		$assignSelectOptions = Rights::getAuthItemSelectOptions(null, $assignments);
		if( $assignSelectOptions!==array() )
		{
			$formModel = new AssignmentForm();

		    // Form is submitted and data is valid, redirect the user
		    if( isset($_POST['AssignmentForm'])===true )
			{
				$formModel->attributes = $_POST['AssignmentForm'];
				if( $formModel->validate()===true )
				{
					// Update and redirect
					$this->_authorizer->authManager->assign($formModel->itemname, $model->getId());
					$item = $this->_authorizer->authManager->getAuthItem($formModel->itemname);
					$item = $this->_authorizer->attachAuthItemBehavior($item);

					Yii::app()->user->setFlash($this->module->flashSuccessKey,
						Rights::t('core', 'Permission :name assigned.', array(':name'=>$item->getNameText()))
					);

					$this->redirect(array('assignment/user', 'id'=>$model->getId()));
				}
			}
		}
		// No items available
		else
		{
		 	$formModel = null;
		}

		// Create a data provider for listing the assignments
		$dataProvider = new RAuthItemDataProvider('assignments', array(
			'userId'=>$model->getId(),
		));

		// Render the view
		$this->render('user', array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
			'formModel'=>$formModel,
			'assignSelectOptions'=>$assignSelectOptions,
		));
	}

	/**
	* Revokes an assignment from an user.
	*/
	public function actionRevoke()
	{
		// We only allow deletion via POST request
		if( Yii::app()->request->isPostRequest===true )
		{
			$itemName = $this->getItemName();
			
			// Revoke the item from the user and load it
			$this->_authorizer->authManager->revoke($itemName, $_GET['id']);
			$item = $this->_authorizer->authManager->getAuthItem($itemName);
			$item = $this->_authorizer->attachAuthItemBehavior($item);

			// Set flash message for revoking the item
			Yii::app()->user->setFlash($this->module->flashSuccessKey,
				Rights::t('core', 'Permission :name revoked.', array(':name'=>$item->getNameText()))
			);

			// if AJAX request, we should not redirect the browser
			if( isset($_POST['ajax'])===false )
				$this->redirect(array('assignment/user', 'id'=>$_GET['id']));
		}
		else
		{
			throw new CHttpException(400, Rights::t('core', 'Invalid request. Please do not repeat this request again.'));
		}
	}
	
	/**
	* @return string the item name or null if not set.
	*/
	public function getItemName()
	{
		return isset($_GET['name'])===true ? urldecode($_GET['name']) : null;
	}
}
