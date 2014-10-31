<?php
$this->breadcrumbs = array(
    Yii::t('StoreModule.store', 'Атрибуты') => array('/store/attributeBackend/index'),
    Yii::t('StoreModule.store', 'Управление'),
);

$this->pageTitle = Yii::t('StoreModule.store', 'Атрибуты - управление');

$this->menu = array(
    array('icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.store', 'Управление атрибутами'), 'url' => array('/store/attributeBackend/index')),
    array('icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.store', 'Добавить атрибут'), 'url' => array('/store/attributeBackend/create')),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.store', 'Атрибуты'); ?>
        <small><?php echo Yii::t('StoreModule.store', 'управление'); ?></small>
    </h1>
</div>

<div class="row">
    <div class="col-sm-3">
        <fieldset>
            <legend>Группы атрибутов</legend>
            <a href="#" id="clear-attribute-group-filter"><?php echo Yii::t("StoreModule.store", "Без групп"); ?></a>
            <a href="#" id="add-attribute-group" class="btn btn-default pull-right"><?php echo Yii::t("StoreModule.store", "Добавить группу"); ?></a>
            <script type="text/javascript">
                $(document).ready(function () {
                    $('#clear-attribute-group-filter').click(function (e) {
                        e.preventDefault();
                        $("#Attribute_group_id").val('').trigger("change");
                        $('#attribute-group-grid').find('tr').removeClass('selected');
                    });

                    $("input[type=checkbox]", "#attribute-group-grid").change(function () {
                        changeGroupFilter();
                    });

                    $('#add-attribute-group').click(function (e) {
                        e.preventDefault();
                        var name = prompt('<?php echo Yii::t("StoreModule.store", "Название"); ?>');
                        if (name) {
                            var data = {name: name};
                            data["<?php echo Yii::app()->getRequest()->csrfTokenName?>"] = "<?php echo Yii::app()->getRequest()->csrfToken?>";
                            $.ajax({
                                url: '<?php echo Yii::app()->createUrl("/store/attributeBackend/groupCreate")?>',
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
            array(
                'id' => 'attribute-group-grid',
                'type' => 'condensed',
                'dataProvider' => $attributeGroup->search(),
                'template' => "{items}\n{multiaction}",
                'hideHeader' => true,
                'selectableRows' => 1,
                'selectionChanged' => 'js:function(id){changeGroupFilter()}',
                'sortableRows' => true,
                'sortableAjaxSave' => true,
                'sortableAttribute' => 'position',
                'sortableAction' => '/store/attributeBackend/groupSortable',
                'columns' => array(
                    array(
                        'name' => 'name',
                        'class' => 'bootstrap.widgets.TbEditableColumn',
                        'headerHtmlOptions' => array('style' => 'width:500px'),
                        'editable' => array(
                            'type' => 'text',
                            'url' => array('/store/attributeBackend/inlineEditGroup'),
                            'title' => Yii::t('StoreModule.store', 'Введите {field}', array('{field}' => mb_strtolower($attributeGroup->getAttributeLabel('name')))),
                            'params' => array(
                                Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                            ),
                            'placement' => 'right',
                        ),
                    ),
                ),
            )
        ); ?>
    </div>
    <div class="col-sm-9">
        <?php $this->widget(
            'yupe\widgets\CustomGridView',
            array(
                'id' => 'attribute-grid',
                'type' => 'condensed',
                'dataProvider' => $model->search(),
                'filter' => $model,
                'columns' => array(
                    array(
                        'name' => 'group_id',
                        'value' => '$data->getGroupTitle()',
                        'filter' => CHtml::activeDropDownList($model, 'group_id', AttributeGroup::model()->getFormattedList(), array('empty' => '', 'class' => 'form-control')),
                    ),
                    array(
                        'name' => 'name',
                        'type' => 'raw',
                        'value' => 'CHtml::link($data->name, array("/store/attributeBackend/update", "id" => $data->id))',
                    ),
                    array(
                        'name' => 'title',
                        'type' => 'raw',
                        'value' => 'CHtml::link($data->title, array("/store/attributeBackend/update", "id" => $data->id))',
                    ),
                    array(
                        'name' => 'type',
                        'type' => 'text',
                        'value' => '$data->getTypeTitle($data->type)',
                        'filter' => $model->getTypesList()
                    ),
                    array(
                        'class' => 'yupe\widgets\CustomButtonColumn',
                    ),
                ),
            )
        ); ?>
    </div>
</div>
