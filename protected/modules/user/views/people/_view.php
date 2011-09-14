<div class="view">       
	
    <b><?php echo $data->getAvatar() ?></b>
    <br />
	
    <b><?php echo CHtml::encode($data->getAttributeLabel('nickName')); ?>:</b>
	<?php echo CHtml::encode($data->nickName); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('creationDate')); ?>:</b>
	<?php echo CHtml::encode($data->creationDate); ?>
	<br />
	
</div>
