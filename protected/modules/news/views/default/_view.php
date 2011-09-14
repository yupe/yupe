<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('creationDate')); ?>:</b>
    <?php echo CHtml::encode($data->creationDate); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('changeDate')); ?>:</b>
    <?php echo CHtml::encode($data->changeDate); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
    <?php echo CHtml::encode($data->date); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
    <?php echo CHtml::encode($data->title); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('alias')); ?>:</b>
    <?php echo CHtml::encode($data->alias); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('shortText')); ?>:</b>
    <?php echo CHtml::encode($data->shortText); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('fullText')); ?>:</b>
    <?php echo CHtml::encode($data->fullText); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('userId')); ?>:</b>
    <?php echo CHtml::encode($data->user->nickName); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
    <?php echo CHtml::encode($data->getStatus()); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('isProtected')); ?>:</b>
    <?php echo CHtml::encode($data->getProtectedStatus()); ?>
    <br/>
</div>