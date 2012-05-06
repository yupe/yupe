<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('creation_date')); ?>
        :</b>
    <?php echo CHtml::encode($data->creation_date); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('change_date')); ?>:</b>
    <?php echo CHtml::encode($data->change_date); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
    <?php echo CHtml::encode($data->name); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
    <?php echo CHtml::encode($data->email); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('theme')); ?>:</b>
    <?php echo CHtml::encode($data->theme); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('text')); ?>:</b>
    <?php echo CHtml::encode($data->text); ?>
    <br/>


    <b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
    <?php echo CHtml::encode($data->getType()); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
    <?php echo CHtml::encode($data->getStatus()); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('ip')); ?>:</b>
    <?php echo CHtml::encode($data->ip); ?>
    <br/>

</div>