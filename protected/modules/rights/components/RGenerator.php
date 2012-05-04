<?php
/**
* Rights generator component class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.9.8
*/
class RGenerator extends CApplicationComponent
{
	private $_authManager;
	private $_items;

	/**
	* @property CDbConnection
	*/
	public $db;

	/**
	* Initializes the generator.
	*/
	public function init()
	{
		parent::init();

		$this->_authManager = Yii::app()->getAuthManager();
		$this->db = $this->_authManager->db;
	}

	/**
	* Runs the generator.
	* @return the items generated or false if failed.
	*/
	public function run()
	{
		$authManager = $this->_authManager;
		$itemTable = $authManager->itemTable;

		// Start transaction
		$txn = $this->db->beginTransaction();

		try
		{
			$generatedItems = array();

			// Loop through each type of items
			foreach( $this->_items as $type=>$items )
			{
				// Loop through items
				foreach( $items as $name )
				{
					// Make sure the item does not already exist
					if( $authManager->getAuthItem($name)===null )
					{
						// Insert item
						$sql = "INSERT INTO {$itemTable} (name, type, data)
							VALUES (:name, :type, :data)";
						$command = $this->db->createCommand($sql);
						$command->bindValue(':name', $name);
						$command->bindValue(':type', $type);
						$command->bindValue(':data', 'N;');
						$command->execute();

						$generatedItems[] = $name;
					}
				}
			}

			// All commands executed successfully, commit
			$txn->commit();
			return $generatedItems;
		}
		catch( CDbException $e )
		{
			// Something went wrong, rollback
			$txn->rollback();
			return false;
		}
	}

	/**
	* Appends items to be generated of a specific type.
	* @param array $items the items to be generated.
	* @param integer $type the item type.
	*/
	public function addItems($items, $type)
	{
		if( isset($this->_items[ $type ])===false )
			$this->_items[ $type ] = array();

		foreach( $items as $itemname )
			$this->_items[ $type ][] = $itemname;
	}

	/**
	* Returns all the controllers and their actions.
	* @param array $items the controllers and actions.
	*/
	public function getControllerActions($items=null)
	{
		if( $items===null )
			$items = $this->getAllControllers();

		foreach( $items['controllers'] as $controllerName=>$controller )
		{
			$actions = array();
			$file = fopen($controller['path'], 'r');
			$lineNumber = 0;
			while( feof($file)===false )
			{
				++$lineNumber;
				$line = fgets($file);
				preg_match('/public[ \t]+function[ \t]+action([A-Z]{1}[a-zA-Z0-9]+)[ \t]*\(/', $line, $matches);
				if( $matches!==array() )
				{
					$name = $matches[1];
					$actions[ strtolower($name) ] = array(
						'name'=>$name,
						'line'=>$lineNumber
					);
				}
			}

			$items['controllers'][ $controllerName ]['actions'] = $actions;
		}

		foreach( $items['modules'] as $moduleName=>$module )
			$items['modules'][ $moduleName ] = $this->getControllerActions($module);

		return $items;
	}

	/**
	* Returns a list of all application controllers.
	* @return array the controllers.
	*/
	protected function getAllControllers()
	{
		$basePath = Yii::app()->basePath;
		$items['controllers'] = $this->getControllersInPath($basePath.DIRECTORY_SEPARATOR.'controllers');
		$items['modules'] = $this->getControllersInModules($basePath);
		return $items;
	}

	/**
	* Returns all controllers under the specified path.
	* @param string $path the path.
	* @return array the controllers.
	*/
	protected function getControllersInPath($path)
	{
		$controllers = array();

		if( file_exists($path)===true )
		{
			$controllerDirectory = scandir($path);
			foreach( $controllerDirectory as $entry )
			{
				if( $entry{0}!=='.' )
				{
					$entryPath = $path.DIRECTORY_SEPARATOR.$entry;
					if( strpos(strtolower($entry), 'controller')!==false )
					{
						$name = substr($entry, 0, -14);
						$controllers[ strtolower($name) ] = array(
							'name'=>$name,
							'file'=>$entry,
							'path'=>$entryPath,
						);
					}

					if( is_dir($entryPath)===true )
						foreach( $this->getControllersInPath($entryPath) as $controllerName=>$controller )
							$controllers[ $controllerName ] = $controller;
				}
			}
		}

		return $controllers;
	}

	/**
	* Returns all the controllers under the specified path.
	* @param string $path the path.
	* @return array the controllers.
	*/
	protected function getControllersInModules($path)
	{
		$items = array();

		$modulePath = $path.DIRECTORY_SEPARATOR.'modules';
		if( file_exists($modulePath)===true )
		{
			$moduleDirectory = scandir($modulePath);
			foreach( $moduleDirectory as $entry )
			{
				if( substr($entry, 0, 1)!=='.' && $entry!=='rights' )
				{
					$subModulePath = $modulePath.DIRECTORY_SEPARATOR.$entry;
					if( file_exists($subModulePath)===true )
					{
						$items[ $entry ]['controllers'] = $this->getControllersInPath($subModulePath.DIRECTORY_SEPARATOR.'controllers');
						$items[ $entry ]['modules'] = $this->getControllersInModules($subModulePath);
					}
				}
			}
		}

		return $items;
	}
}
