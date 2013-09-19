<?php
/**
 *## BootstrapFilter class file
 *
 * @author Ricardo Obregón <ricardo@obregon.co>
 * @date 18/12/12 09:35 AM
 */


/**
 *## Class BootstrapFilter
 *
 * Filter to load Bootstrap on specific actions.
 * Then in a controller, add the new bootstrap filter:
 * <code>public function filters()
 * {
 *     return array(
 *         'accessControl',
 *         'postOnly + delete',
 *         array('ext.bootstrap.filters.BootstrapFilter - delete')
 *     );
 * }</code>
 *
 * @package booster.filters
 */
class BootstrapFilter extends CFilter
{
	protected function preFilter($filterChain)
	{
		Yii::app()->getComponent("bootstrap");
		return true;
	}
}
