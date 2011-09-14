<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('userId')); ?>:</b>
    <?php echo CHtml::encode($data->user->nickName); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('creationDate')); ?>
        :</b>
    <?php echo CHtml::encode($data->creationDate); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('code')); ?>:</b>
    <?php echo CHtml::encode($data->code); ?>
    <br/>


</div>