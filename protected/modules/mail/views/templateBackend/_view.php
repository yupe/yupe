<div class="view">

	<b><?php echo  CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo  CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo  CHtml::encode($data->getAttributeLabel('code')); ?>:</b>
	<?php echo  CHtml::encode($data->code); ?>
	<br />

	<b><?php echo  CHtml::encode($data->getAttributeLabel('event_id')); ?>:</b>
	<?php echo  CHtml::encode($data->event_id); ?>
	<br />

	<b><?php echo  CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo  CHtml::encode($data->name); ?>
	<br />

	<b><?php echo  CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo  CHtml::encode($data->description); ?>
	<br />

	<b><?php echo  CHtml::encode($data->getAttributeLabel('from')); ?>:</b>
	<?php echo  CHtml::encode($data->from); ?>
	<br />

	<b><?php echo  CHtml::encode($data->getAttributeLabel('to')); ?>:</b>
	<?php echo  CHtml::encode($data->to); ?>
	<br />
	
	<b><?php echo  CHtml::encode($data->getAttributeLabel('theme')); ?>:</b>
	<?php echo  CHtml::encode($data->theme); ?>
	<br />

	<b><?php echo  CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo  CHtml::encode($data->status); ?>
	<br />
</div>