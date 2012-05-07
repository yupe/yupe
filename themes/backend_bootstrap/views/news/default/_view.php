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

    <b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
    <?php echo CHtml::encode($data->date); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
    <?php echo CHtml::encode($data->title); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('alias')); ?>:</b>
    <?php echo CHtml::encode($data->alias); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('short_text')); ?>:</b>
    <?php echo CHtml::encode($data->short_text); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('full_text')); ?>:</b>
    <?php echo CHtml::encode($data->full_text); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
    <?php echo CHtml::encode($data->user->nick_name); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
    <?php echo CHtml::encode($data->getStatus()); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('is_protected')); ?>
        :</b>
    <?php echo CHtml::encode($data->getProtectedStatus()); ?>
    <br/>
</div>