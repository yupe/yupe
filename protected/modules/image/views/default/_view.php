<div class="view">

    <?php echo CHtml::image($data->file, $data->alt, array('width' => 50, 'height' => 50));?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
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

    <b><?php echo CHtml::encode($data->getAttributeLabel('file')); ?>:</b>
    <?php echo CHtml::encode($data->file); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('creation_date')); ?>
        :</b>
    <?php echo CHtml::encode($data->creation_date); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
    <?php echo CHtml::encode($data->user->getFullName()); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('alt')); ?>:</b>
    <?php echo CHtml::encode($data->alt); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
    <?php echo CHtml::encode($data->getType()); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
    <?php echo CHtml::encode($data->getStatus()); ?>
    <br/>

</div>