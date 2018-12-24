<?php
$this->breadcrumbs = [
    Yii::t('StoreModule.store', 'Attributes') => ['/store/attributeBackend/index'],
    Yii::t('StoreModule.store', 'Manage'),
];

$this->pageTitle = Yii::t('StoreModule.store', 'Attributes - manage');

$this->menu = [
    [
        'icon' => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('StoreModule.store', 'Manage attributes'),
        'url' => ['/store/attributeBackend/index'],
    ],
    [
        'icon' => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('StoreModule.store', 'Create attribute'),
        'url' => ['/store/attributeBackend/create'],
    ],
];
?>
<div class="page-header">
    <h1>
        <?= Yii::t('StoreModule.store', 'Attributes'); ?>
        <small><?= Yii::t('StoreModule.store', 'administration'); ?></small>
    </h1>
</div>

<div class="row">
    <div class="col-sm-3">
        <fieldset>
            <legend><?= Yii::t("StoreModule.store", "Attribute groups"); ?></legend>

        </fieldset>
        <?php
        $this->widget(
            'yupe\widgets\CustomGridView',
            [
                'id' => 'attributes-groups-grid',
                'type' => 'condensed',
                'dataProvider' => $attributeGroup->search(),
                'template' => "{items}\n{multiaction}\n{pager}",
                'hideHeader' => true,
                'selectableRows' => 1,
                'sortableRows' => true,
                'sortableAjaxSave' => true,
                'sortableAttribute' => 'position',
                'sortableAction' => '/store/attributeBackend/sortable',
                'afterSortableUpdate' => 'js: function(id, position) {
                    $.fn.yiiGridView.update("attributes-grid");
                }',
                'actionsButtons' => [
                    'add' => CHtml::link(
                        Yii::t('YupeModule.yupe', 'Add'),
                        '#',
                        ['id' => 'add-attribute-group', 'class' => 'btn btn-sm btn-success pull-right']
                    ),
                ],
                'columns' => [
                    [
                        'name' => 'name',
                        'class' => 'bootstrap.widgets.TbEditableColumn',
                        'headerHtmlOptions' => ['style' => 'width:500px'],
                        'editable' => [
                            'type' => 'text',
                            'url' => ['/store/attributeBackend/inlineEditGroup'],
                            'title' => Yii::t('StoreModule.store', 'Enter {field}',
                                ['{field}' => mb_strtolower($attributeGroup->getAttributeLabel('name'))]),
                            'params' => [
                                Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken,
                            ],
                            'placement' => 'right',
                        ],
                    ],
                ],
            ]
        ); ?>
    </div>
    <div class="col-sm-9">
        <?php $this->widget(
            'yupe\widgets\CustomGridView',
            [
                'id' => 'attributes-grid',
                'sortableRows' => true,
                'sortableAjaxSave' => true,
                'sortableAttribute' => 'sort',
                'sortableAction' => '/store/attributeBackend/sortattr',
                'type' => 'condensed',
                'dataProvider' => $model->search(),
                'filter' => $model,
                'columns' => [
                    [
                        'name' => 'title',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return CHtml::link($data->title,
                                array("/store/attributeBackend/update", "id" => $data->id));
                        },
                    ],
                    [
                        'name' => 'name',
                        'type' => 'raw',
                        'value' => function ($data) {
                            return CHtml::link($data->name, array("/store/attributeBackend/update", "id" => $data->id));
                        },
                    ],
                    [
                        'name' => 'type',
                        'type' => 'text',
                        'value' => function ($data) {
                            return $data->getTypeTitle($data->type);
                        },
                        'filter' => $model->getTypesList(),
                    ],
                    [
                        'name' => 'group_id',
                        'value' => function ($data) {
                            return $data->getGroupTitle();
                        },
                        'filter' => CHtml::activeDropDownList($model, 'group_id',
                            AttributeGroup::model()->getFormattedList(), ['empty' => '', 'class' => 'form-control']),
                    ],
                    [
                        'class' => 'yupe\widgets\EditableStatusColumn',
                        'name' => 'required',
                        'url' => $this->createUrl('/store/attributeBackend/inlineattr'),
                        'source' => $model->getYesNoList(),
                        'options' => [
                            ['class' => 'label-default'],
                            ['class' => 'label-success'],
                        ],
                    ],
                    [
                        'class' => 'yupe\widgets\EditableStatusColumn',
                        'name' => 'is_filter',
                        'url' => $this->createUrl('/store/attributeBackend/inlineattr'),
                        'source' => $model->getYesNoList(),
                        'options' => [
                            ['class' => 'label-default'],
                            ['class' => 'label-success'],
                        ],
                    ],
                    [
                        'class' => 'yupe\widgets\CustomButtonColumn',
                        'template' => '{update}{delete}',
                    ],
                ],
            ]
        ); ?>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var $container = $('body');
        $container.on('click', '#add-attribute-group', function (e) {
            e.preventDefault();
            var name = prompt('<?= Yii::t("StoreModule.store", "Title"); ?>');
            if (name) {
                var data = {name: name};
                data["<?= Yii::app()->getRequest()->csrfTokenName?>"] = "<?= Yii::app()->getRequest()->csrfToken?>";
                $.ajax({
                    url: '<?= Yii::app()->createUrl("/store/attributeBackend/groupCreate")?>',
                    type: 'post',
                    data: data,
                    dataType: 'json',
                    success: function (data) {
                        if (data.result) {
                            $.fn.yiiGridView.update('attributes-groups-grid');
                        }
                    }
                });
            }
        });
    });
</script>
