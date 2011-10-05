<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('creation_date')); ?>
        :</b>
    <?php echo CHtml::encode($data->creation_date); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('nickName')); ?>:</b>
    <?php echo CHtml::encode($data->nickName); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
    <?php echo CHtml::encode($data->email); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('salt')); ?>:</b>
    <?php echo CHtml::encode($data->salt); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('password')); ?>:</b>
    <?php echo CHtml::encode($data->password); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('code')); ?>:</b>
    <?php echo CHtml::encode($data->code); ?>
    <br/>


</div>