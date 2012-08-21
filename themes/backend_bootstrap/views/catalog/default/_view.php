<div class="view">

	<b><?php echo  CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo  CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo  CHtml::encode($data->getAttributeLabel('category_id')); ?>:</b>
	<?php echo  CHtml::encode($data->category_id); ?>
	<br />

	<b><?php echo  CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo  CHtml::encode($data->name); ?>
	<br />

	<b><?php echo  CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo  CHtml::encode($data->price); ?>
	<br />

	<b><?php echo  CHtml::encode($data->getAttributeLabel('article')); ?>:</b>
	<?php echo  CHtml::encode($data->article); ?>
	<br />

	<b><?php echo  CHtml::encode($data->getAttributeLabel('image')); ?>:</b>
	<?php echo  CHtml::encode($data->image); ?>
	<br />

	<b><?php echo  CHtml::encode($data->getAttributeLabel('short_description')); ?>:</b>
	<?php echo  CHtml::encode($data->short_description); ?>
	<br />

	<?php /*
	<b><?php echo  CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo  CHtml::encode($data->description); ?>
	<br />

	<b><?php echo  CHtml::encode($data->getAttributeLabel('alias')); ?>:</b>
	<?php echo  CHtml::encode($data->alias); ?>
	<br />

	<b><?php echo  CHtml::encode($data->getAttributeLabel('data')); ?>:</b>
	<?php echo  CHtml::encode($data->data); ?>
	<br />

	<b><?php echo  CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo  CHtml::encode($data->status); ?>
	<br />

	<b><?php echo  CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
	<?php echo  CHtml::encode($data->create_time); ?>
	<br />

	<b><?php echo  CHtml::encode($data->getAttributeLabel('update_time')); ?>:</b>
	<?php echo  CHtml::encode($data->update_time); ?>
	<br />

	<b><?php echo  CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo  CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo  CHtml::encode($data->getAttributeLabel('change_user_id')); ?>:</b>
	<?php echo  CHtml::encode($data->change_user_id); ?>
	<br />

	*/ ?>

</div>