<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('parent_Id')); ?>:</b>
    <?php echo CHtml::encode($data->parent_Id); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('creation_date')); ?>
        :</b>
    <?php echo CHtml::encode($data->creation_date); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('change_date')); ?>:</b>
    <?php echo CHtml::encode($data->change_date); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
    <?php echo CHtml::encode($data->title); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
    <?php echo CHtml::encode($data->name); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('menu_order')); ?>:</b>
    <?php echo CHtml::encode($data->menu_order); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('slug')); ?>:</b>
    <?php echo CHtml::encode($data->slug); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('body')); ?>:</b>
    <?php echo CHtml::encode($data->body); ?>
    <br/>

    <?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('keywords')); ?>:</b>
	<?php echo CHtml::encode($data->keywords); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	*/ ?>

</div>