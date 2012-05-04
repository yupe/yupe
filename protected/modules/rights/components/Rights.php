<?php
/**
* Rights helper class file.
*
* Provides static functions for interaction with Rights from outside of the module.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.9.1
*/
class Rights
{
	const PERM_NONE = 0;
	const PERM_DIRECT = 1;
	const PERM_INHERITED = 2;

	private static $_m;
	private static $_a;

	/**
	* Assigns an authorization item to a specific user.
	* @param string $itemName the name of the item to assign.
	* @param integer $userId the user id of the user for which to assign the item.
	* @param string $bizRule business rule associated with the item. This is a piece of
	* PHP code that will be executed when {@link checkAccess} is called for the item.
	* @param mixed $data additional data associated with the item.
	* @return CAuthItem the authorization item
	*/
	public static function assign($itemName, $userId, $bizRule=null, $data=null)
	{
		$authorizer = self::getAuthorizer();
		return $authorizer->authManager->assign($itemName, $userId, $bizRule, $data);
	}

	/**
	* Revokes an authorization item from a specific user.
	* @param string $itemName the name of the item to revoke.
	* @param integer $userId the user id of the user for which to revoke the item.
	* @return boolean whether the item was removed.
	*/
	public static function revoke($itemName, $userId)
	{
		$authorizer = self::getAuthorizer();
		return $authorizer->authManager->revoke($itemName, $userId);
	}

	/**
	* Returns the roles assigned to a specific user.
	* If no user id is provided the logged in user will be used.
	* @param integer $userId the user id of the user for which roles to get.
	* @param boolean $sort whether to sort the items by their weights.
	* @return array the roles.
	*/
	public static function getAssignedRoles($userId=null, $sort=true)
	{
		$user = Yii::app()->getUser();
		if( $userId===null && $user->isGuest===false )
			$userId = $user->id;

	 	$authorizer = self::getAuthorizer();
	 	return $authorizer->getAuthItems(CAuthItem::TYPE_ROLE, $userId, null, $sort);
	}

	/**
	* Returns the base url to Rights.
	* @return the url to Rights.
	*/
	public static function getBaseUrl()
	{
		$module = self::module();
		return Yii::app()->createUrl($module->baseUrl);
	}
	
	/**
	* Returns the list of authorization item types.
	* @return array the list of types.
	*/
	public static function getAuthItemOptions()
	{
		return array(
			CAuthItem::TYPE_OPERATION=>Rights::t('core', 'Operation'),
			CAuthItem::TYPE_TASK=>Rights::t('core', 'Task'),
			CAuthItem::TYPE_ROLE=>Rights::t('core', 'Role'),
		);
	}

	/**
	* Returns the name of a specific authorization item.
	* @param integer $type the item type (0: operation, 1: task, 2: role).
	* @return string the authorization item type name.
	*/
	public static function getAuthItemTypeName($type)
	{
		$options = self::getAuthItemOptions();
		if( isset($options[ $type ])===true )
			return $options[ $type ];
		else
			throw new CException(Rights::t('core', 'Invalid authorization item type.'));
	}

	/**
	* Returns the name of a specific authorization item in plural.
	* @param integer $type the item type (0: operation, 1: task, 2: role).
	* @return string the authorization item type name.
	*/
	public static function getAuthItemTypeNamePlural($type)
	{
		switch( (int)$type )
		{
			case CAuthItem::TYPE_OPERATION: return Rights::t('core', 'Operations');
			case CAuthItem::TYPE_TASK: return Rights::t('core', 'Tasks');
			case CAuthItem::TYPE_ROLE: return Rights::t('core', 'Roles');
			default: throw new CException(Rights::t('core', 'Invalid authorization item type.'));
		}
	}

	/**
	* Returns the route to a specific authorization item list view.
	* @param integer $type the item type (0: operation, 1: task, 2: role).
	* @return array the route.
	*/
	public static function getAuthItemRoute($type)
	{
		switch( (int)$type )
		{
			case CAuthItem::TYPE_OPERATION: return array('authItem/operations');
			case CAuthItem::TYPE_TASK: return array('authItem/tasks');
			case CAuthItem::TYPE_ROLE: return array('authItem/roles');
			default: throw new CException(Rights::t('core', 'Invalid authorization item type.'));
		}
	}

	/**
	* Returns the valid child item types for a specific type.
	* @param string $type the item type (0: operation, 1: task, 2: role).
	* @return array the valid types.
	*/
	public static function getValidChildTypes($type)
	{
	 	switch( (int)$type )
		{
			// Roles can consist of any type of authorization items
			case CAuthItem::TYPE_ROLE: return null;
			// Tasks can consist of other tasks and operations
			case CAuthItem::TYPE_TASK: return array(CAuthItem::TYPE_TASK, CAuthItem::TYPE_OPERATION);
			// Operations can consist of other operations
			case CAuthItem::TYPE_OPERATION: return array(CAuthItem::TYPE_OPERATION);
			// Invalid type
			default: throw new CException(Rights::t('core', 'Invalid authorization item type.'));
		}
	}

	/**
	* Returns the authorization item select options.
	* @param mixed $type the item type (0: operation, 1: task, 2: role). Defaults to null,
	* meaning returning all items regardless of their type.
	* @param array $exclude the items to be excluded.
	* @return array the select options.
	*/
	public static function getAuthItemSelectOptions($type=null, $exclude=array())
	{
		$authorizer = self::getAuthorizer();
		$items = $authorizer->getAuthItems($type, null, null, true, $exclude);
		return self::generateAuthItemSelectOptions($items, $type);
	}

	/**
	* Returns the valid authorization item select options for a model.
	* @param mixed $parent the item type (0: operation, 1: task, 2: role). Defaults to null,
	* meaning returning all items regardless of their type.
	* @param CAuthItem $type the item for which to get the select options.
	* @param array $exclude the items to be excluded.
	* @return array the select options.
	*/
	public static function getParentAuthItemSelectOptions(CAuthItem $parent, $type=null, $exclude=array())
	{
		$authorizer = self::getAuthorizer();
		$items = $authorizer->getAuthItems($type, null, $parent, true, $exclude);
		return self::generateAuthItemSelectOptions($items, $type);
	}

	/**
	* Generates the authorization item select options.
	* @param array $items the authorization items.
	* @param mixed $type the item type (0: operation, 1: task, 2: role).
	* @return array the select options.
	*/
	protected static function generateAuthItemSelectOptions($items, $type)
	{
		$selectOptions = array();

		// We have multiple types, nest the items under their types
       	if( $type!==(int)$type )
       	{
       		foreach( $items as $itemName=>$item )
				$selectOptions[ self::getAuthItemTypeNamePlural($item->type) ][ $itemName ] = $item->getNameText();
		}
		// We have only one type
		else
		{
			foreach( $items as $itemName=>$item )
        		$selectOptions[ $itemName ] = $item->getNameText();
		}

		return $selectOptions;
	}
	
	/**
	* Returns the cross-site request forgery parameter 
	* to be placed in the data of Ajax-requests.
	* An empty string is returned if csrf-validation is disabled.
	* @return string the csrf parameter.
	*/
	public static function getDataCsrf()
	{
		return ($csrf = self::getCsrfParam())!==null ? ', '.$csrf : '';
	}

	/**
	* Returns the cross-site request forgery parameter for Ajax-requests.
	* Null is returned if csrf-validation is disabled.
	* @return string the csrf parameter.
	*/
	public static function getCsrfParam()
	{
		if( Yii::app()->request->enableCsrfValidation===true )
		{
	        $csrfTokenName = Yii::app()->request->csrfTokenName;
	        $csrfToken = Yii::app()->request->csrfToken;
	        return "'$csrfTokenName':'$csrfToken'";
		}
		else
		{
			return null;
		}
	}

	/**
	* @return string a string that can be displayed on your Web page
	* showing Powered-by-Rights information.
	*/
	public static function powered()
	{
		$module = self::module();
		return 'Secured with <a href="http://www.yiiframework.com/extension/rights" rel="external">Rights</a> version '.$module->getVersion().'.';
	}

	/**
	* @return RightsModule the Rights module.
	*/
	public static function module()
	{
		if( isset(self::$_m)===false )
			self::$_m = self::findModule();

		return self::$_m;
	}

	/**
	* Searches for the Rights module among all installed modules.
	* The module will be found even if it's nested within another module.
	* @param CModule $module the module to find the module in. Defaults to null,
	* meaning that the application will be used.
	* @return the Rights module.
	*/
	private static function findModule(CModule $module=null)
	{
		if( $module===null )
			$module = Yii::app();

		if( ($m = $module->getModule('rights'))!==null )
			return $m;

		foreach( $module->getModules() as $id=>$c )
			if( ($m = self::findModule( $module->getModule($id) ))!==null )
				return $m;

		return null;
	}

	/**
	* @return RAuthorizer the authorizer component.
	*/
	public static function getAuthorizer()
	{
		if( isset(self::$_a)===false )
			self::$_a = self::module()->getAuthorizer();

		return self::$_a;
	}

	/**
	* Translates a message to the specified language.
	* Wrapper class for setting the category correctly.
	* @param string $category message category.
	* @param string $message the original message.
	* @param array $params parameters to be applied to the message using <code>strtr</code>.
	* @param string $source which message source application component to use.
	* @param string $language the target language.
	* @return string the translated message.
	*/
	public static function t($category, $message, $params=array(), $source=null, $language=null)
	{
		return Yii::t('RightsModule.'.$category, $message, $params, $source, $language);
	}
}
