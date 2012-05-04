<?php
/**
* Authorization item parent data provider class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.9.10
*/
class RAuthItemParentDataProvider extends RAuthItemDataProvider
{
	/**
	* Constructs the data provider.
	* @param string $parent the data provider identifier.
	* @param array $config configuration (name=>value) to be applied as the initial property values of this class.
	* @return RightsAuthItemDataProvider
	*/
	public function __construct($parent, $config=array())
	{
		$this->parent = $parent;
		$this->setId($parent->name);

		foreach($config as $key=>$value)
			$this->$key = $value;
	}

	/**
	* Fetches the data from the persistent data storage.
	* @return array list of data items
	*/
	public function fetchData()
	{
		$this->items = Rights::getAuthorizer()->getAuthItemParents($this->parent->name, $this->type, null, true);
		return parent::fetchData();
	}
}
