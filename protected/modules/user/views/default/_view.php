<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('creationDate')); ?>
        :</b>
    <?php echo CHtml::encode($data->creationDate); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('changeDate')); ?>:</b>
    <?php echo CHtml::encode($data->changeDate); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('firstName')); ?>:</b>
    <?php echo CHtml::encode($data->firstName); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('lastName')); ?>:</b>
    <?php echo CHtml::encode($data->lastName); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('nickName')); ?>:</b>
    <?php echo CHtml::encode($data->nickName); ?>
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('accessLevel')); ?>:</b>
	<?php echo CHtml::encode($data->accessLevel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lastVisit')); ?>:</b>
	<?php echo CHtml::encode($data->lastVisit); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('registrationDate')); ?>:</b>
	<?php echo CHtml::encode($data->registrationDate); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('registrationIp')); ?>:</b>
	<?php echo CHtml::encode($data->registrationIp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('activationIp')); ?>:</b>
	<?php echo CHtml::encode($data->activationIp); ?>
	<br />

	*/ ?>

</div>