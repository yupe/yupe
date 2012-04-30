<div class="view">

    <b><?=CHtml::encode($data->getAttributeLabel('id'))?>:</b>
    <?=CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id))?>
    <br />

    <b><?=CHtml::encode($data->getAttributeLabel('name'))?>:</b>
    <?=CHtml::encode($data->name)?>
    <br />

    <b><?=CHtml::encode($data->getAttributeLabel('code'))?>:</b>
    <?=CHtml::encode($data->code)?>
    <br />

    <b><?=CHtml::encode($data->getAttributeLabel('description'))?>:</b>
    <?=CHtml::encode($data->description)?>
    <br />

    <b><?=CHtml::encode($data->getAttributeLabel('status'))?>:</b>
    <?=CHtml::encode($data->status)?>
    <br />

</div>