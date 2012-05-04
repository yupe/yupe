<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
    <?php echo CHtml::encode($data->name); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
    <?php echo CHtml::encode($data->description); ?>
    <br />

    <b><?php echo CHtml::encode(Yii::t('blog','Записей')); ?>:</b>
    <?php echo CHtml::encode($data->postsCount); ?>
    <br />

    <b><?php echo CHtml::encode(Yii::t('blog','Участников')); ?>:</b>
    <?php echo CHtml::encode($data->membersCount); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('icon')); ?>:</b>
    <?php echo CHtml::encode($data->icon); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('slug')); ?>:</b>
    <?php echo CHtml::encode($data->slug); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
    <?php echo CHtml::encode($data->getType()); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
    <?php echo CHtml::encode($data->getStatus()); ?>
    <br />
    
    <b><?php echo CHtml::encode($data->getAttributeLabel('create_user_id')); ?>:</b>
    <?php echo CHtml::encode($data->createUser->getFullName()); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('update_user_id')); ?>:</b>
    <?php echo CHtml::encode($data->updateUser->getFullName()); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('create_date')); ?>:</b>
    <?php echo CHtml::encode($data->create_date); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('update_date')); ?>:</b>
    <?php echo CHtml::encode($data->update_date); ?>
    <br />

</div>