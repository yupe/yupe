<?php
/**
* Rights authorization item controller class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.5
*/
class AuthItemController extends RController
{
	/**
	* @property RAuthorizer
	*/
	private $_authorizer;
	/**
	* @property CAuthItem the currently loaded data model instance.
	*/
	private $_model;

	/**
	* Initializes the controller.
	*/
	public function init()
	{
		$this->_authorizer = $this->module->getAuthorizer();
		$this->layout = $this->module->layout;
		$this->defaultAction = 'permissions';

		// Register the scripts
		$this->module->registerScripts();
	}

	/**
	* @return array action filters
	*/
	public function filters()
	{
		return array(
			'accessControl'
		);
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
					'permissions',
					'operations',
					'tasks',
					'roles',
					'generate',
					'create',
					'update',
					'delete',
					'removeChild',
					'assign',
					'revoke',
					'sortable',
				),
				'users'=>$this->_authorizer->getSuperusers(),
			),
			array('deny', // Deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	* Displays the permission overview.
	*/
	public function actionPermissions()
	{
		$dataProvider = new RPermissionDataProvider('permissions');

		// Get the roles from the data provider
		$roles = $dataProvider->getRoles();
		$roleColumnWidth = $roles!==array() ? 75/count($roles) : 0;

		// Initialize the columns
		$columns = array(
			array(
    			'name'=>'description',
	    		'header'=>Rights::t('core', 'Item'),
				'type'=>'raw',
    			'htmlOptions'=>array(
    				'class'=>'permission-column',
    				'style'=>'width:25%',
	    		),
    		),
		);

		// Add a column for each role
    	foreach( $roles as $roleName=>$role )
    	{
    		$columns[] = array(
				'name'=>strtolower($roleName),
    			'header'=>$role->getNameText(),
    			'type'=>'raw',
    			'htmlOptions'=>array(
    				'class'=>'role-column',
    				'style'=>'width:'.$roleColumnWidth.'%',
    			),
    		);
		}

		$view = 'permissions';
		$params = array(
			'dataProvider'=>$dataProvider,
			'columns'=>$columns,
		);

		// Render the view
		isset($_POST['ajax'])===true ? $this->renderPartial($view, $params) : $this->render($view, $params);
	}

	/**
	* Displays the operation management page.
	*/
	public function actionOperations()
	{
		Yii::app()->user->rightsReturnUrl = array('authItem/operations');
		
		$dataProvider = new RAuthItemDataProvider('operations', array(
			'type'=>CAuthItem::TYPE_OPERATION,
			'sortable'=>array(
				'id'=>'RightsOperationTableSort',
				'element'=>'.operation-table',
				'url'=>$this->createUrl('authItem/sortable'),
			),
		));

		// Render the view
		$this->render('operations', array(
			'dataProvider'=>$dataProvider,
			'isBizRuleEnabled'=>$this->module->enableBizRule,
			'isBizRuleDataEnabled'=>$this->module->enableBizRuleData,
		));
	}

	/**
	* Displays the operation management page.
	*/
	public function actionTasks()
	{
		Yii::app()->user->rightsReturnUrl = array('authItem/tasks');
		
		$dataProvider = new RAuthItemDataProvider('tasks', array(
			'type'=>CAuthItem::TYPE_TASK,
			'sortable'=>array(
				'id'=>'RightsTaskTableSort',
				'element'=>'.task-table',
				'url'=>$this->createUrl('authItem/sortable'),
			),
		));

		// Render the view
		$this->render('tasks', array(
			'dataProvider'=>$dataProvider,
			'isBizRuleEnabled'=>$this->module->enableBizRule,
			'isBizRuleDataEnabled'=>$this->module->enableBizRuleData,
		));
	}

	/**
	* Displays the role management page.
	*/
	public function actionRoles()
	{
		Yii::app()->user->rightsReturnUrl = array('authItem/roles');
		
		$dataProvider = new RAuthItemDataProvider('roles', array(
			'type'=>CAuthItem::TYPE_ROLE,
			'sortable'=>array(
				'id'=>'RightsRoleTableSort',
				'element'=>'.role-table',
				'url'=>$this->createUrl('authItem/sortable'),
			),
		));

		// Render the view
		$this->render('roles', array(
			'dataProvider'=>$dataProvider,
			'isBizRuleEnabled'=>$this->module->enableBizRule,
			'isBizRuleDataEnabled'=>$this->module->enableBizRuleData,
		));
	}

	/**
	* Displays the generator page.
	*/
	public function actionGenerate()
	{
		// Get the generator and authorizer
		$generator = $this->module->getGenerator();

		// Createh the form model
		$model = new GenerateForm();

		// Form has been submitted
		if( isset($_POST['GenerateForm'])===true )
		{
			// Form is valid
			$model->attributes = $_POST['GenerateForm'];
			if( $model->validate()===true )
			{
				$items = array(
					'tasks'=>array(),
					'operations'=>array(),
				);

				// Get the chosen items
				foreach( $model->items as $itemname=>$value )
				{
					if( (bool)$value===true )
					{
						if( strpos($itemname, '*')!==false )
							$items['tasks'][] = $itemname;
						else
							$items['operations'][] = $itemname;
					}
				}

				// Add the items to the generator as tasks and operations and run the generator.
				$generator->addItems($items['tasks'], CAuthItem::TYPE_TASK);
				$generator->addItems($items['operations'], CAuthItem::TYPE_OPERATION);
				if( ($generatedItems = $generator->run())!==false && $generatedItems!==array() )
				{
					Yii::app()->getUser()->setFlash($this->module->flashSuccessKey,
						Rights::t('core', 'Authorization items created.')
					);
					$this->redirect(array('authItem/permissions'));
				}
			}
		}

		// Get all items that are available to be generated
		$items = $generator->getControllerActions();

		// We need the existing operations for comparason
		$authItems = $this->_authorizer->getAuthItems(array(
			CAuthItem::TYPE_TASK,
			CAuthItem::TYPE_OPERATION,
		));
		$existingItems = array();
		foreach( $authItems as $itemName=>$item )
			$existingItems[ $itemName ] = $itemName;

		Yii::app()->clientScript->registerScript('rightsGenerateItemTableSelectRows',
			"jQuery('.generate-item-table').rightsSelectRows();"
		);

		// Render the view
		$this->render('generate', array(
			'model'=>$model,
			'items'=>$items,
			'existingItems'=>$existingItems,
		));
	}

	/**
	* Creates an authorization item.
	* @todo add type validation.
	*/
	public function actionCreate()
	{
		$type = $this->getType();
		
		// Create the authorization item form
		$formModel = new AuthItemForm('create');

		if( isset($_POST['AuthItemForm'])===true )
		{
			$formModel->attributes = $_POST['AuthItemForm'];
			if( $formModel->validate()===true )
			{
				// Create the item
				$item = $this->_authorizer->createAuthItem($formModel->name, $type, $formModel->description, $formModel->bizRule, $formModel->data);
				$item = $this->_authorizer->attachAuthItemBehavior($item);

				// Set a flash message for creating the item
				Yii::app()->user->setFlash($this->module->flashSuccessKey,
					Rights::t('core', ':name created.', array(':name'=>$item->getNameText()))
				);

				// Redirect to the correct destination
				$this->redirect(Yii::app()->user->getRightsReturnUrl(array('authItem/permissions')));
			}
		}

		// Render the view
		$this->render('create', array(
			'formModel'=>$formModel,
		));
	}

	/**
	* Updates an authorization item.
	*/
	public function actionUpdate()
	{
		// Get the authorization item
		$model = $this->loadModel();
		$itemName = $model->getName();
		
		// Create the authorization item form
		$formModel = new AuthItemForm('update');

		if( isset($_POST['AuthItemForm'])===true )
		{
			$formModel->attributes = $_POST['AuthItemForm'];
			if( $formModel->validate()===true )
			{
				// Update the item and load it
				$this->_authorizer->updateAuthItem($itemName, $formModel->name, $formModel->description, $formModel->bizRule, $formModel->data);
				$item = $this->_authorizer->authManager->getAuthItem($formModel->name);
				$item = $this->_authorizer->attachAuthItemBehavior($item);

				// Set a flash message for updating the item
				Yii::app()->user->setFlash($this->module->flashSuccessKey,
					Rights::t('core', ':name updated.', array(':name'=>$item->getNameText()))
				);

				// Redirect to the correct destination
				$this->redirect(Yii::app()->user->getRightsReturnUrl(array('authItem/permissions')));
			}
		}
		
		$type = Rights::getValidChildTypes($model->type);
		$exclude = array($this->module->superuserName);
		$childSelectOptions = Rights::getParentAuthItemSelectOptions($model, $type, $exclude);
		
		if( $childSelectOptions!==array() )
		{
			$childFormModel = new AuthChildForm();
		
			// Child form is submitted and data is valid
			if( isset($_POST['AuthChildForm'])===true )
			{
				$childFormModel->attributes = $_POST['AuthChildForm'];
				if( $childFormModel->validate()===true )
				{
					// Add the child and load it
					$this->_authorizer->authManager->addItemChild($itemName, $childFormModel->itemname);
					$child = $this->_authorizer->authManager->getAuthItem($childFormModel->itemname);
					$child = $this->_authorizer->attachAuthItemBehavior($child);

					// Set a flash message for adding the child
					Yii::app()->user->setFlash($this->module->flashSuccessKey,
						Rights::t('core', 'Child :name added.', array(':name'=>$child->getNameText()))
					);

					// Reidrect to the same page
					$this->redirect(array('authItem/update', 'name'=>urlencode($itemName)));
				}
			}
		}
		else
		{
			$childFormModel = null;
		}

		// Set the values for the form fields
		$formModel->name = $model->name;
		$formModel->description = $model->description;
		$formModel->type = $model->type;
		$formModel->bizRule = $model->bizRule!=='NULL' ? $model->bizRule : '';
		$formModel->data = $model->data!==null ? serialize($model->data) : '';

		$parentDataProvider = new RAuthItemParentDataProvider($model);
		$childDataProvider = new RAuthItemChildDataProvider($model);

		// Render the view
		$this->render('update', array(
			'model'=>$model,
			'formModel'=>$formModel,
			'childFormModel'=>$childFormModel,
			'childSelectOptions'=>$childSelectOptions,
			'parentDataProvider'=>$parentDataProvider,
			'childDataProvider'=>$childDataProvider,
		));
	}

	/**
	 * Deletes an operation.
	 */
	public function actionDelete()
	{
		// We only allow deletion via POST request
		if( Yii::app()->request->isPostRequest===true )
		{
			$itemName = $this->getItemName();
			
			// Load the item and save the name for later use
			$item = $this->_authorizer->authManager->getAuthItem($itemName);
			$item = $this->_authorizer->attachAuthItemBehavior($item);

			// Delete the item
			$this->_authorizer->authManager->removeAuthItem($itemName);

			// Set a flash message for deleting the item
			Yii::app()->user->setFlash($this->module->flashSuccessKey,
				Rights::t('core', ':name deleted.', array(':name'=>$item->getNameText()))
			);

			// If AJAX request, we should not redirect the browser
			if( isset($_POST['ajax'])===false )
				$this->redirect(Yii::app()->user->getRightsReturnUrl(array('authItem/permissions')));
		}
		else
		{
			throw new CHttpException(400, Rights::t('core', 'Invalid request. Please do not repeat this request again.'));
		}
	}

	/**
	* Removes a child from an authorization item.
	*/
	public function actionRemoveChild()
	{
		// We only allow deletion via POST request
		if( Yii::app()->request->isPostRequest===true )
		{
			$itemName = $this->getItemName();
			$childName = $this->getChildName();
			
			// Remove the child and load it
			$this->_authorizer->authManager->removeItemChild($itemName, $childName);
			$child = $this->_authorizer->authManager->getAuthItem($childName);
			$child = $this->_authorizer->attachAuthItemBehavior($child);

			// Set a flash message for removing the child
			Yii::app()->user->setFlash($this->module->flashSuccessKey,
				Rights::t('core', 'Child :name removed.', array(':name'=>$child->getNameText()))
			);

			// If AJAX request, we should not redirect the browser
			if( isset($_POST['ajax'])===false )
				$this->redirect(array('authItem/update', 'name'=>urlencode($itemName)));
		}
		else
		{
			throw new CHttpException(400, Rights::t('core', 'Invalid request. Please do not repeat this request again.'));
		}
	}

	/**
	* Adds a child to an authorization item.
	*/
	public function actionAssign()
	{
		// We only allow deletion via POST request
		if( Yii::app()->request->isPostRequest===true )
		{
			$model = $this->loadModel();
			$childName = $this->getChildName();
			
			if( $childName!==null && $model->hasChild($childName)===false )
				$model->addChild($childName);

			// if AJAX request, we should not redirect the browser
			if( isset($_POST['ajax'])===false )
				$this->redirect(array('authItem/permissions'));
		}
		else
		{
			throw new CHttpException(400, Rights::t('core', 'Invalid request. Please do not repeat this request again.'));
		}
	}

	/**
	* Removes a child from an authorization item.
	*/
	public function actionRevoke()
	{
		// We only allow deletion via POST request
		if( Yii::app()->request->isPostRequest===true )
		{
			$model = $this->loadModel();
			$childName = $this->getChildName();

			if( $childName!==null && $model->hasChild($childName)===true )
				$model->removeChild($childName);

			// if AJAX request, we should not redirect the browser
			if( isset($_POST['ajax'])===false )
				$this->redirect(array('authItem/permissions'));
		}
		else
		{
			throw new CHttpException(400, Rights::t('core', 'Invalid request. Please do not repeat this request again.'));
		}
	}

	/**
	* Processes the jui sortable.
	*/
	public function actionSortable()
	{
		// We only allow sorting via POST request
		if( Yii::app()->request->isPostRequest===true )
		{
			$this->_authorizer->authManager->updateItemWeight($_POST['result']);
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
	
	/**
	* @return string the child name or null if not set.
	*/
	public function getChildName()
	{
		return isset($_GET['child'])===true ? urldecode($_GET['child']) : null;
	}
	
	/**
	 * Returns the authorization item type after validation.
	 * @return int the type.
	 */
	public function getType()
	{
		$type = $_GET['type'];
		$validTypes = array(CAuthItem::TYPE_OPERATION, CAuthItem::TYPE_TASK, CAuthItem::TYPE_ROLE);
		if( in_array($type, $validTypes)===true )
			return $type;
		else
			throw new CException(Rights::t('core', 'Invalid authorization item type.'));
	}

	/**
	* Returns the data model based on the primary key given in the GET variable.
	* If the data model is not found, an HTTP exception will be raised.
	*/
	public function loadModel()
	{
		if( $this->_model===null )
		{
			$itemName = $this->getItemName();
			
			if( $itemName!==null )
			{
				$this->_model = $this->_authorizer->authManager->getAuthItem($itemName);
				$this->_model = $this->_authorizer->attachAuthItemBehavior($this->_model);
			}

			if( $this->_model===null )
				throw new CHttpException(404, Rights::t('core', 'The requested page does not exist.'));
		}

		return $this->_model;
	}
}
