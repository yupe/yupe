<?php
/**
* Rights user behavior class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.9.10
*/
class RUserBehavior extends CModelBehavior
{
	/**
	* @property the name of the id column.
	*/
	public $idColumn;
	/**
	* @property the name of the name column.
	*/
	public $nameColumn;
	
	private $_assignments;

	/**
	* Returns the value of the owner's id column.
	* Attribute name is retrived from the module configuration.
	* @return string the id.
	*/
	public function getId()
	{
		if( $this->idColumn===null )
			$this->idColumn = Rights::module()->userIdColumn;

		return $this->owner->{$this->idColumn};
	}

	/**
	* Returns the value of the owner's name column.
	* Attribute name is retrived from the module configuration.
	* @return string the name.
	*/
	public function getName()
	{
		if( $this->nameColumn===null )
			$this->nameColumn = Rights::module()->userNameColumn;

		return $this->owner->{$this->nameColumn};
	}

	/**
	* Returns a link labeled with the username pointing to the users assignments.
	* @return string the link markup.
	*/
	public function getAssignmentNameLink()
	{
		return CHtml::link($this->getName(), array('assignment/user', 'id'=>$this->getId()));
	}
	
	/**
	 * Returns a string with names of the authorization items
	 * of the given type that are assigned to this user.
	 * @param integer $type the item type (0: operation, 1: task, 2: role).
	 * @return mixed the assigned items. 
	 */
	public function getAssignmentsText($type)
	{
		$assignedItems = $this->getAssignments();
		
		if( isset($assignedItems[ $type ])===true )
		{
			$items = $assignedItems[ $type ];
			$names = array();
			foreach( $items as $itemname=>$item )
				$names[] = $item->getNameText();
			
			return implode('<br />', $names);
		}
	}

	/**
	* Returns the authorization items assigned to the user.
	* @return string the assignments markup.
	*/
	public function getAssignments()
	{
		if( $this->_assignments!==null )
		{
			return $this->_assignments;
		}
		else
		{
			$authorizer = Rights::getAuthorizer();
			$authAssignments = $authorizer->authManager->getAuthAssignments($this->getId());
			$nestedItems = $authorizer->authManager->getAuthItemsByNames(array_keys($authAssignments), true);

			$assignments = array();
			foreach( $nestedItems as $type=>$items )
			{
				$items = $authorizer->attachAuthItemBehavior($items);
				$assignments[ $type ] = array();
				foreach( $items as $itemName=>$item )
					$assignments[ $type ][ $itemName ] = $item;
			}

			return $this->_assignments = $assignments;
		}
	}
}