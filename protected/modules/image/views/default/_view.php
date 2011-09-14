<div class="view">

    <?php echo CHtml::image($data->file, $data->alt, array('width' => 50, 'height' => 50));?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
    <?php echo CHtml::encode($data->name); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
    <?php echo CHtml::encode($data->description); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('file')); ?>:</b>
    <?php echo CHtml::encode($data->file); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('creationDate')); ?>:</b>
    <?php echo CHtml::encode($data->creationDate); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('userId')); ?>:</b>
    <?php echo CHtml::encode($data->user->getFullName()); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('alt')); ?>:</b>
    <?php echo CHtml::encode($data->alt); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
    <?php echo CHtml::encode($data->getStatus()); ?>
    <br/>

</div>