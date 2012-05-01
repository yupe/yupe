<div class="view">

    <b><?=CHtml::encode($data->getAttributeLabel('id'))?>:</b>
    <?=CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id))?>
    <br />

    <b><?=CHtml::encode($data->getAttributeLabel('title'))?>:</b>
    <?=CHtml::encode($data->title)?>
    <br />

    <b><?=CHtml::encode($data->getAttributeLabel('href'))?>:</b>
    <?=CHtml::encode($data->href)?>
    <br />

    <b><?=CHtml::encode($data->getAttributeLabel('type'))?>:</b>
    <?=CHtml::encode($data->type)?>
    <br />

    <b><?=CHtml::encode($data->getAttributeLabel('menu_id'))?>:</b>
    <?=CHtml::encode($data->menu->name)?>
    <br />

    <b><?=CHtml::encode($data->getAttributeLabel('parent_id'))?>:</b>
    <?=CHtml::encode($data->parent->title)?>
    <br />

    <b><?=CHtml::encode($data->getAttributeLabel('sort'))?>:</b>
    <?=CHtml::encode($data->sort)?>
    <br />

    <b><?=CHtml::encode($data->getAttributeLabel('status'))?>:</b>
    <?=CHtml::encode($data->status)?>
    <br />

</div>