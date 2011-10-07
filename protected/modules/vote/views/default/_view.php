<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('model')); ?>:</b>
    <?php echo CHtml::encode($data->model); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('model_id')); ?>:</b>
    <?php echo CHtml::encode($data->model_id); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
    <?php echo CHtml::encode($data->user_id); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('creation_date')); ?>
        :</b>
    <?php echo CHtml::encode($data->creation_date); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('value')); ?>:</b>
    <?php echo CHtml::encode($data->value); ?>
    <br/>


</div>