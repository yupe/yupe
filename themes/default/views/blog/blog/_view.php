<div class="view">
    
    <b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->name),array('/blog/blog/show/','slug' => $data->slug)); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('create_date')); ?>:</b>
    <?php echo CHtml::encode($data->createUser->getFullName()); ?>
    <?php echo CHtml::encode($data->create_date); ?>    
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
    <?php echo CHtml::encode($data->description); ?>
    <br/>    
    
</div>
