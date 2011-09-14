<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('model')); ?>:</b>
    <?php echo CHtml::encode($data->model); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('modelId')); ?>:</b>
    <?php echo CHtml::encode($data->modelId); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('userId')); ?>:</b>
    <?php echo CHtml::encode($data->userId); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('creationDate')); ?>:</b>
    <?php echo CHtml::encode($data->creationDate); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('value')); ?>:</b>
    <?php echo CHtml::encode($data->value); ?>
    <br/>


</div>