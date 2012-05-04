<?php $this->breadcrumbs = array(
	'Rights'=>Rights::getBaseUrl(),
	Rights::t('core', 'Permissions'),
); ?>

<div id="permissions">

	<h2><?php echo Rights::t('core', 'Permissions'); ?></h2>

	<p>
		<?php echo Rights::t('core', 'Here you can view and manage the permissions assigned to each role.'); ?><br />
		<?php echo Rights::t('core', 'Authorization items can be managed under {roleLink}, {taskLink} and {operationLink}.', array(
			'{roleLink}'=>CHtml::link(Rights::t('core', 'Roles'), array('authItem/roles')),
			'{taskLink}'=>CHtml::link(Rights::t('core', 'Tasks'), array('authItem/tasks')),
			'{operationLink}'=>CHtml::link(Rights::t('core', 'Operations'), array('authItem/operations')),
		)); ?>
	</p>

	<p><?php echo CHtml::link(Rights::t('core', 'Generate items for controller actions'), array('authItem/generate'), array(
	   	'class'=>'generator-link',
	)); ?></p>

	<?php $this->widget('zii.widgets.grid.CGridView', array(
		'dataProvider'=>$dataProvider,
		'template'=>'{items}',
		'emptyText'=>Rights::t('core', 'No authorization items found.'),
		'htmlOptions'=>array('class'=>'grid-view permission-table'),
		'columns'=>$columns,
	)); ?>

	<p class="info">*) <?php echo Rights::t('core', 'Hover to see from where the permission is inherited.'); ?></p>

	<script type="text/javascript">

		/**
		* Attach the tooltip to the inherited items.
		*/
		jQuery('.inherited-item').rightsTooltip({
			title:'<?php echo Rights::t('core', 'Source'); ?>: '
		});

		/**
		* Hover functionality for rights' tables.
		*/
		$('#rights tbody tr').hover(function() {
			$(this).addClass('hover'); // On mouse over
		}, function() {
			$(this).removeClass('hover'); // On mouse out
		});

	</script>

</div>
