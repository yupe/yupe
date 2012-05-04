<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('parent_id')); ?>:</b>
    <?php echo CHtml::encode($data->parent_id); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
    <?php echo CHtml::encode($data->name); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>
        :</b>
    <?php echo CHtml::encode($data->description); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('alias')); ?>:</b>
    <?php echo CHtml::encode($data->alias); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
    <?php echo CHtml::encode($data->status); ?>
    <br/>


</div>