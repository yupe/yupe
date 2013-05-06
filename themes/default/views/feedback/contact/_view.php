<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('creation_date')); ?>
        :</b>
    <?php echo CHtml::encode($data->creation_date); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
    <?php echo CHtml::encode($data->name); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('theme')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->theme),array('/feedback/contact/faqView/','id' => $data->id)); ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('text')); ?>:</b>
    <?php echo $data->text; ?>
    <br/>

    <b><?php echo CHtml::encode($data->getAttributeLabel('answer')); ?>:</b>
    <?php echo $data->answer; ?>
    <br/>

</div>