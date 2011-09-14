<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('userId')); ?>:</b>
    <?php echo CHtml::encode($data->user->getFullName() . " ({$data->user->nickName})"); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('identityId')); ?>:</b>
    <?php echo CHtml::encode($data->identityId); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
    <?php echo CHtml::encode($data->type); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('creationDate')); ?>:</b>
    <?php echo CHtml::encode($data->creationDate); ?>
    <br/>


</div>