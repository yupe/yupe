<?php
/**
* Rights authorization item behavior class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.9.11
*/
class RAuthItemBehavior extends CBehavior
{
	/**
	* @property integer the id of the user to whom this item is assigned.
	*/
	public $userId;
	/**
	* @property CAuthItem the parent item.
	*/
	public $parent;
	/**
	* @property integer the amount of children this item has.
	*/
	public $childCount;

	/**
	* Constructs the behavior.
	* @param integer $userId the id of the user to whom this item is assigned
	* @param CAuthItem $parent the parent item.
	*/
	public function __construct($userId=null, CAuthItem $parent=null)
	{
		$this->userId = $userId;
		$this->parent = $parent;
	}

	/**
	* Returns the item name.
	* @return string the markup.
	*/
	public function getNameText()
	{
		return (Rights::module()->displayDescription===true && $this->owner->description!==null) ? $this->owner->description : $this->owner->name;
	}

	/**
	* Returns the link to update the item.
	* @return string the markup.
	*/
	public function getNameLink()
	{
		return CHtml::link($this->getNameText(), array(
			'authItem/update',
			'name'=>urlencode($this->owner->name),
		));
	}
	
	/**
	* Returns the markup for the name link to displayed in the grid.
	* @return string the markup. 
	*/
	public function getGridNameLink()
	{
		$markup = CHtml::link($this->owner->name, array(
			'authItem/update',
			'name'=>urlencode($this->owner->name),
		));

		$markup .= $this->childCount();
		$markup .= $this->sortableId();

		return $markup;
	}

	/**
	* Returns the markup for the child count.
	* @return string the markup.
	*/
	public function childCount()
	{
		if( $this->childCount===null )
			$this->childCount = count($this->owner->getChildren());

		return $this->childCount>0 ? ' [ <span class="child-count">'.$this->childCount.'</span> ]' : '';
	}

	/**
	* Returns the markup for the id required by jui sortable.
	* @return string the markup.
	*/
	public function sortableId()
	{
	 	return ' <span class="auth-item-name" style="display:none;">'.$this->owner->name.'</span>';
	}

	/**
	* Returns the markup for the item type.
	* @return string the markup.
	*/
	public function getTypeText()
	{
		return Rights::getAuthItemTypeName($this->owner->type);
	}

	/**
	* Returns the markup for the delete operation link.
	* @return string the markup.
	*/
	public function getDeleteOperationLink()
	{
		return CHtml::linkButton(Rights::t('core', 'Delete'), array(
			'submit'=>array('authItem/delete', 'name'=>urlencode($this->owner->name)),
			'confirm'=>Rights::t('core', 'Are you sure you want to delete this operation?'),
			'class'=>'delete-link',
			'csrf'=>Yii::app()->request->enableCsrfValidation,
		));
	}

	/**
	* Returns the markup for the delete task link.
	* @return string the markup.
	*/
	public function getDeleteTaskLink()
	{
		return CHtml::linkButton(Rights::t('core', 'Delete'), array(
			'submit'=>array('authItem/delete', 'name'=>urlencode($this->owner->name)),
			'confirm'=>Rights::t('core', 'Are you sure you want to delete this task?'),
			'class'=>'delete-link',
			'csrf'=>Yii::app()->request->enableCsrfValidation,
		));
	}

	/**
	* Returns the markup for the delete role link.
	* @return string the markup.
	*/
	public function getDeleteRoleLink()
	{
		// We do not want to show the delete link for the superuser role.
		if( $this->owner->name!==Rights::module()->superuserName )
		{
			return CHtml::linkButton(Rights::t('core', 'Delete'), array(
				'submit'=>array('authItem/delete', 'name'=>urlencode($this->owner->name)),
				'confirm'=>Rights::t('core', 'Are you sure you want to delete this role?'),
				'class'=>'delete-link',
				'csrf'=>Yii::app()->request->enableCsrfValidation,
			));
		}
	}

	/**
	* Returns the markup for the remove parent link.
	* @return string the markup.
	*/
	public function getRemoveParentLink()
	{
		return CHtml::linkButton(Rights::t('core', 'Remove'), array(
			'submit'=>array('authItem/removeChild', 'name'=>urlencode($this->owner->name), 'child'=>urlencode($this->parent->name)),
			'class'=>'remove-link',
			'csrf'=>Yii::app()->request->enableCsrfValidation,
		));
	}

	/**
	* Returns the markup for the remove child link.
	* @return string the markup.
	*/
	public function getRemoveChildLink()
	{
		return CHtml::linkButton(Rights::t('core', 'Remove'), array(
			'submit'=>array('authItem/removeChild', 'name'=>urlencode($this->parent->name), 'child'=>urlencode($this->owner->name)),
			'class'=>'remove-link',
			'csrf'=>Yii::app()->request->enableCsrfValidation,
		));
	}

	/**
	* Returns the markup for the revoke assignment link.
	* @return string the markup.
	*/
	public function getRevokeAssignmentLink()
	{
		return CHtml::linkButton(Rights::t('core', 'Revoke'), array(
			'submit'=>array('assignment/revoke', 'id'=>$this->userId, 'name'=>urlencode($this->owner->name)),
			'class'=>'revoke-link',
			'csrf'=>Yii::app()->request->enableCsrfValidation,
		));
	}
	
	/**
	* Returns the markup for the revoke permission link.
	* @param CAuthItem $role the role the permission is for.
	* @return string the markup.
	*/
	public function getRevokePermissionLink(CAuthItem $role)
	{
		$csrf = Rights::getDataCsrf();
		
		return CHtml::link(Rights::t('core', 'Revoke'), '#', array(
			'onclick'=>"
				jQuery.ajax({
					type:'POST',
					url:'".Yii::app()->controller->createUrl('authItem/revoke', array(
						'name'=>urlencode($role->name), 
						'child'=>urlencode($this->owner->name),
					))."',
					data:{ ajax:1 $csrf },
					success:function() {
						$('#permissions').load('".Yii::app()->controller->createUrl('authItem/permissions')."', { ajax:1 $csrf });
					}
				});

				return false;				
			",
			'class'=>'revoke-link',
		));
	}

	/**
	* Returns the markup for the assign permission link.
	* @param CAuthItem $role the role the permission is for.
	* @return string the markup.
	*/
	public function getAssignPermissionLink(CAuthItem $role)
	{
		$csrf = Rights::getDataCsrf();
		
		return CHtml::link(Rights::t('core', 'Assign'), '#', array(
			'onclick'=>"
				jQuery.ajax({
					type:'POST',
					url:'".Yii::app()->controller->createUrl('authItem/assign', array(
						'name'=>urlencode($role->name), 
						'child'=>urlencode($this->owner->name),
					))."',
					data:{ ajax:1 $csrf },
					success:function() {
						$('#permissions').load('".Yii::app()->controller->createUrl('authItem/permissions')."', { ajax:1 $csrf });
					}
				});

				return false;				
			",
			'class'=>'assign-link',
		));
	}
	
	/**
	* Returns the markup for a inherited permission.
	* @param array $parents the parents for this item.
	* @param boolean $displayType whether to display the parent item type.
	* @return string the markup.
	*/
	public function getInheritedPermissionText($parents, $displayType=false)
	{
		$items = array();
		foreach( $parents as $itemName=>$item )
		{
			$itemMarkup = $item->getNameText();

			if( $displayType===true )
				$itemMarkup .= ' ('.Rights::getAuthItemTypeName($item->type).')';

			$items[] = $itemMarkup;
		}

		return '<span class="inherited-item" title="'.implode('<br />', $items).'">'.Rights::t('core', 'Inherited').' *</span>';
	}
}
