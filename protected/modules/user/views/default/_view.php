<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('creation_date')); ?>
        :</b>
    <?php echo CHtml::encode($data->creation_date); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('change_date')); ?>:</b>
    <?php echo CHtml::encode($data->change_date); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('first_name')); ?>:</b>
    <?php echo CHtml::encode($data->first_name); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('last_name')); ?>:</b>
    <?php echo CHtml::encode($data->last_name); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('nick_name')); ?>:</b>
    <?php echo CHtml::encode($data->nick_name); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
    <?php echo CHtml::encode($data->email); ?>
    <br/>

    <?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('gender')); ?>:</b>
	<?php echo CHtml::encode($data->gender); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('avatar')); ?>:</b>
	<?php echo CHtml::encode($data->avatar); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('password')); ?>:</b>
	<?php echo CHtml::encode($data->password); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('salt')); ?>:</b>
	<?php echo CHtml::encode($data->salt); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('access_level')); ?>:</b>
	<?php echo CHtml::encode($data->access_level); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_visit')); ?>:</b>
	<?php echo CHtml::encode($data->last_visit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('registration_date')); ?>:</b>
	<?php echo CHtml::encode($data->registration_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('registration_ip')); ?>:</b>
	<?php echo CHtml::encode($data->registration_ip); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('activation_ip')); ?>:</b>
	<?php echo CHtml::encode($data->activation_ip); ?>
	<br />

	*/ ?>

</div>