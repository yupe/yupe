<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php
    echo CHtml::link(CHtml::encode($data->id), array(
        'view',
        'id' => $data->id,
    ));
    ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
    <?php echo CHtml::encode($data->title); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('href')); ?>:</b>
    <?php echo CHtml::encode($data->href); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
    <?php echo CHtml::encode($data->type); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('menu_id')); ?>:</b>
    <?php echo CHtml::encode($data->menu->name); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('parent_id')); ?>:</b>
    <?php echo CHtml::encode($data->parent->title); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('sort')); ?>:</b>
    <?php echo CHtml::encode($data->sort); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
    <?php echo CHtml::encode($data->status); ?>
    <br />

</div>