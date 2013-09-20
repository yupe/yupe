<?php
/**
 *## TbSortableAction class file
 *
 * @author ruslan fadeev <fadeevr@gmail.com>
 */

/**
 *## TbSortableAction CAction Component
 *
 * It is a component that works in conjunction of TbExtendedGridView widget with sortableRows true. Just attach to the controller you wish to
 * make the calls to.
 *
 * @package booster.actions
 */
class TbSortableAction extends CAction
{
	/**
	 * @var string the name of the model we are going to toggle values to
	 */
	public $modelName;

	/**
	 * Widgets run function
	 * @throws CHttpException
	 */
	public function run()
	{
		if (!$this->isValidRequest())
			throw new CHttpException(400, Yii::t('yii', 'Your request is invalid.'));

		$sortableAttribute = Yii::app()->request->getQuery('sortableAttribute');

		/** @var $model CActiveRecord */
		$model = new $this->modelName;
		if (!$model->hasAttribute($sortableAttribute)) {
			throw new CHttpException(400, Yii::t(
				'yii',
				'{attribute} "{value}" is invalid.',
				array('{attribute}' => 'sortableAttribute', '{value}' => $sortableAttribute)
			));
		}

		$sortOrderData = $_POST['sortOrder'];

		$query = $this->makeUpdateQuery($model, $sortableAttribute, $sortOrderData);
		Yii::app()->db->createCommand($query)->execute();

	}

	private function isValidRequest()
	{
		return Yii::app()->request->isPostRequest
			&& Yii::app()->request->isAjaxRequest
			&& isset($_POST['sortOrder']);
	}

	/**
	 * @param $model
	 * @param $sortableAttribute
	 * @param $sortOrderData
	 *
	 * @return string
	 */
	private function makeUpdateQuery($model, $sortableAttribute, $sortOrderData)
	{
		$query = "UPDATE {$model->tableName()} SET {$sortableAttribute} = CASE ";
		$ids = array();
		foreach ($sortOrderData as $id => $sort_order) {
			$id = intval($id);
			$sort_order = intval($sort_order);
			$query .= "WHEN {$model->tableSchema->primaryKey}={$id} THEN {$sort_order} ";
			$ids[] = $id;
		}
		$query .= "END WHERE {$model->tableSchema->primaryKey} IN (" . implode(',', $ids) . ');';
		return $query;
	}
}
