<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
    <?php echo CHtml::encode($data->name); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>
        :</b>
    <?php echo CHtml::encode($data->description); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('startAddImage')); ?>
        :</b>
    <?php echo CHtml::encode($data->startAddImage); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('stopAddImage')); ?>
        :</b>
    <?php echo CHtml::encode($data->stopAddImage); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('startVote')); ?>:</b>
    <?php echo CHtml::encode($data->startVote); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('stopVote')); ?>:</b>
    <?php echo CHtml::encode($data->stopVote); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
    <?php echo CHtml::encode($data->getStatus()); ?>
    <br/>

</div>