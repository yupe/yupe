<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view',
    'id'=> $data->id)); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('worker')); ?>:</b>
    <?php echo CHtml::encode($data->worker); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('create_time')); ?>:</b>
    <?php echo CHtml::encode($data->create_time); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('task')); ?>:</b>
    <?php echo CHtml::encode($data->task); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('start_time')); ?>:</b>
    <?php echo CHtml::encode($data->start_time); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('complete_time')); ?>:</b>
    <?php echo CHtml::encode($data->complete_time); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
    <?php echo CHtml::encode($data->status); ?>
    <br/>
   
    <b><?php echo CHtml::encode($data->getAttributeLabel('error')); ?>:</b>
    <?php echo CHtml::encode($data->error); ?>
    <br />

</div>