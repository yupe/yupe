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

    <b><?php echo CHtml::encode($data->getAttributeLabel('start_add_image')); ?>
        :</b>
    <?php echo CHtml::encode($data->start_add_image); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('stop_add_image')); ?>
        :</b>
    <?php echo CHtml::encode($data->stop_add_image); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('start_vote')); ?>:</b>
    <?php echo CHtml::encode($data->start_vote); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('stop_vote')); ?>:</b>
    <?php echo CHtml::encode($data->stop_vote); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
    <?php echo CHtml::encode($data->getStatus()); ?>
    <br/>

</div>