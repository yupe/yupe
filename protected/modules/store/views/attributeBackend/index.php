<?php
$this->breadcrumbs = [
    Yii::t('StoreModule.store', 'Attributes') => ['/store/attributeBackend/index'],
    Yii::t('StoreModule.store', 'Manage'),
];

$this->pageTitle = Yii::t('StoreModule.store', 'Attributes - manage');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.store', 'Manage attributes'), 'url' => ['/store/attributeBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.store', 'Create attribute'), 'url' => ['/store/attributeBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?= Yii::t('StoreModule.store', 'Attributes'); ?>
        <small><?= Yii::t('StoreModule.store', 'administration'); ?></small>
    </h1>
</div>

<div class="row">
    <div class="col-sm-4">
        <fieldset>
            <legend><?= Yii::t("StoreModule.store", "Attribute groups"); ?></legend>
            <script type="text/javascript">
                $(document).ready(function () {
                    var $container = $('body');
                    $container.on('click', '#clear-attribute-group-filter', function (e) {
                        e.preventDefault();
                        $("#Attribute_group_id").val('').trigger("change");
                        $('#attribute-group-grid').find('tr').removeClass('selected');
                    });

                    // TODO: вызывается два раза, надо сделать, чтобы обновление грида происходило только один раз
                    $container.on('change', "#attribute-group-grid input[type=checkbox]", function () {
                        changeGroupFilter();
                    });

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
                                        $.fn.yiiGridView.update('attribute-group-grid');
                                    }
                                    else {
                                        console.log(data.data);
                                    }
                                }
                            });
                        }
                    });
                });

                function changeGroupFilter() {
                    if (!$('#attribute-group-grid').find('a.editable-open')[0]) {
                        $("#Attribute_group_id").val($.fn.yiiGridView.getSelection('attribute-group-grid')).trigger("change");
                    }
                }
            </script>
        </fieldset>
        <?php
        $attributeGroup = new AttributeGroup('search');
        $attributeGroup->unsetAttributes();
        $this->widget(
            'yupe\widgets\CustomGridView',
            [
                'id' => 'attribute-group-grid',
                'type' => 'condensed',
                'dataProvider' => $attributeGroup->search(),
                'template' => "{items}\n{multiaction}",
                'hideHeader' => true,
                'selectableRows' => 1,
                'sortableRows' => true,
                'sortableAjaxSave' => true,
                'sortableAttribute' => 'position',
                'sortableAction' => '/store/attributeBackend/sortable',
                'actionsButtons' => [
                    'clear' => CHtml::link(
                        Yii::t("StoreModule.store", "Without a group"),
                        '#',
                        ['id' => 'clear-attribute-group-filter', 'class' => 'btn btn-sm btn-default']
                    ),
                    'add' => CHtml::link(
                        Yii::t('YupeModule.yupe', 'Add'),
                        '#',
                        ['id' => 'add-attribute-group', 'class' => 'btn btn-sm btn-success pull-right']
                    ),
                ],
                'afterAjaxUpdate' => 'js:function(id, data){ changeGroupFilter(); }',
                'columns' => [
                    [
                        'name' => 'name',
                        'class' => 'bootstrap.widgets.TbEditableColumn',
                        'headerHtmlOptions' => ['style' => 'width:500px'],
                        'editable' => [
                            'type' => 'text',
                            'url' => ['/store/attributeBackend/inlineEditGroup'],
                            'title' => Yii::t('StoreModule.store', 'Enter {field}', ['{field}' => mb_strtolower($attributeGroup->getAttributeLabel('name'))]),
                            'params' => [
                                Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                            ],
                            'placement' => 'right',
                        ],
                    ],
                ],
            ]
        ); ?>
    </div>
    <div class="col-sm-8">
        <?php $this->widget(
            'yupe\widgets\CustomGridView',
            [
                'id' => 'attribute-grid',
                'type' => 'condensed',
                'dataProvider' => $model->search(),
                'filter' => $model,
                'columns' => [
                    [
                        'name' => 'group_id',
                        'value' => '$data->getGroupTitle()',
                        'filter' => CHtml::activeDropDownList($model, 'group_id', AttributeGroup::model()->getFormattedList(), ['empty' => '', 'class' => 'form-control']),
                    ],
                    [
                        'name' => 'name',
                        'type' => 'raw',
                        'value' => 'CHtml::link($data->name, array("/store/attributeBackend/update", "id" => $data->id))',
                    ],
                    [
                        'name' => 'title',
                        'type' => 'raw',
                        'value' => 'CHtml::link($data->title, array("/store/attributeBackend/update", "id" => $data->id))',
                    ],
                    [
                        'name' => 'type',
                        'type' => 'text',
                        'value' => '$data->getTypeTitle($data->type)',
                        'filter' => $model->getTypesList()
                    ],
                    [
                        'class' => 'yupe\widgets\CustomButtonColumn',
                    ],
                ],
            ]
        ); ?>
    </div>
</div>
