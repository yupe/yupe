<?php
/**
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <support@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     https://yupe.ru
 *
 * @var $this MenuitemBackendController
 * @var $model MenuItem
 * @var $form \yupe\widgets\ActiveForm
 */
?>

<style>
    .vcenter {
        display: inline-block;
        vertical-align: bottom;
        float: none;
    }

    .row .no-float {
        display: table-cell;
        float: none;
    }
</style>

<ul class="nav nav-tabs">
    <li class="active"><a href="#common" data-toggle="tab"><?= Yii::t("MenuModule.menu", "General"); ?></a></li>
    <li><a href="#options" data-toggle="tab"><?= Yii::t("MenuModule.menu", "Extended settings"); ?></a></li>
</ul>

<?php
$form = $this->beginWidget(
    'yupe\widgets\ActiveForm',
    [
        'id' => 'menu-item-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'type' => 'vertical',
        'htmlOptions' => ['class' => 'well'],
    ]
); ?>
<div class="alert alert-info">
    <?= Yii::t('MenuModule.menu', 'Fields with'); ?>
    <span class="required">*</span>
    <?= Yii::t('MenuModule.menu', 'are required.'); ?>
</div>

<?= $form->errorSummary($model); ?>

<div class="tab-content">
    <div class="tab-pane active" id="common">

        <div class="row">
            <?php
            $menu_id = '#' . CHtml::activeId($model, 'menu_id');
            $parent_id = '#' . CHtml::activeId($model, 'parent_id');
            ?>
            <div class="col-sm-3">
                <?= $form->dropDownListGroup(
                    $model,
                    'menu_id',
                    [
                        'widgetOptions' => [
                            'data' => CHtml::listData(Menu::model()->findAll(), 'id', 'name'),
                            'htmlOptions' => [
                                'class' => 'popover-help',
                                'data-original-title' => $model->getAttributeLabel('menu_id'),
                                'data-content' => $model->getAttributeDescription('menu_id'),
                                'empty' => Yii::t('MenuModule.menu', '--choose menu--'),
                                'ajax' => [
                                    'type' => 'POST',
                                    'url' => $this->createUrl(
                                        '/menu/menuitemBackend/dynamicparent',
                                        (!$model->getIsNewRecord() ? ['id' => $model->id] : [])
                                    ),
                                    'update' => $parent_id,
                                    'beforeSend' => "function () {
                            $('" . $parent_id . "').attr('disabled', true);
                            if ($('" . $menu_id . " option:selected').val() == '')
                                return false;
                        }",
                                    'complete' => "function () {
                            $('" . $parent_id . "').attr('disabled', false);
                        }",
                                ],
                            ],
                        ],
                    ]
                ); ?>
            </div>
            <div class="col-sm-3">
                <?= $form->dropDownListGroup(
                    $model,
                    'parent_id',
                    [
                        'widgetOptions' => [
                            'data' => $model->getParentTree(),
                            'htmlOptions' => [
                                'disabled' => ($model->menu_id) ? false : true,
                                'encode' => false,
                                'class' => 'popover-help',
                                'data-original-title' => $model->getAttributeLabel('parent_id'),
                                'data-content' => $model->getAttributeDescription('parent_id'),
                            ],
                        ],
                    ]
                ); ?>
            </div>
            <div class="col-sm-2">
                <?= $form->dropDownListGroup(
                    $model,
                    'status',
                    [
                        'widgetOptions' => [
                            'data' => $model->getStatusList(),
                            'htmlOptions' => [
                                'class' => 'popover-help',
                                'data-original-title' => $model->getAttributeLabel('status'),
                                'data-content' => $model->getAttributeDescription('status'),
                            ],
                        ],
                    ]
                ); ?>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-6 ">
                <?= $form->textFieldGroup(
                    $model,
                    'title',
                    [
                        'widgetOptions' => [
                            'htmlOptions' => [
                                'class' => 'popover-help',
                                'data-original-title' => $model->getAttributeLabel('title'),
                                'data-content' => $model->getAttributeDescription('title'),
                            ],
                        ],
                    ]
                ); ?>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-6 no-float">
                <?= $form->textFieldGroup(
                    $model,
                    'href',
                    [
                        'widgetOptions' => [
                            'htmlOptions' => [
                                'class' => 'popover-help',
                                'data-original-title' => $model->getAttributeLabel('href'),
                                'data-content' => $model->getAttributeDescription('href'),
                            ],
                        ],
                    ]
                ); ?>

            </div>

            <div class="col-sm-2 no-float vcenter">
                <div class="form-group">
                    <button class="btn btn-default " type="button" data-toggle="modal" data-target="#myModal">Выбрать
                        ссылку
                    </button>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <?= $form->checkBoxGroup(
                    $model,
                    'regular_link',
                    [
                        'widgetOptions' => [
                            'htmlOptions' => [
                                'class' => 'popover-help',
                                'data-original-title' => $model->getAttributeLabel('regular_link'),
                                'data-content' => $model->getAttributeDescription('regular_link'),
                            ],
                        ],
                    ]
                ); ?>
            </div>
        </div>
        <div class="row hidden">
            <div class="col-sm-7">
                <?= $form->textFieldGroup($model, 'sort'); ?>
            </div>
        </div>
    </div>
    <div class="tab-pane" id="options">

        <div class="row">
            <div class="col-sm-7">
                <?= $form->textFieldGroup(
                    $model,
                    'title_attr',
                    [
                        'widgetOptions' => [
                            'data' => $model->getStatusList(),
                            'htmlOptions' => [
                                'class' => 'popover-help',
                                'data-original-title' => $model->getAttributeLabel('title_attr'),
                                'data-content' => $model->getAttributeDescription('title_attr'),
                            ],
                        ],
                    ]
                ); ?>
            </div>

        </div>
        <div class="row">
            <div class="col-sm-7">
                <?= $form->textFieldGroup(
                    $model,
                    'class',
                    [
                        'widgetOptions' => [
                            'data' => $model->getStatusList(),
                            'htmlOptions' => [
                                'class' => 'popover-help',
                                'data-original-title' => $model->getAttributeLabel('class'),
                                'data-content' => $model->getAttributeDescription('class'),
                            ],
                        ],
                    ]
                ); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <?= $form->textFieldGroup(
                    $model,
                    'before_link',
                    [
                        'widgetOptions' => [
                            'data' => $model->getStatusList(),
                            'htmlOptions' => [
                                'class' => 'popover-help',
                                'data-original-title' => $model->getAttributeLabel('before_link'),
                                'data-content' => $model->getAttributeDescription('before_link'),
                            ],
                        ],
                    ]
                ); ?>
            </div>
            <div class="col-sm-4">
                <?= $form->textFieldGroup(
                    $model,
                    'after_link',
                    [
                        'widgetOptions' => [
                            'data' => $model->getStatusList(),
                            'htmlOptions' => [
                                'class' => 'popover-help',
                                'data-original-title' => $model->getAttributeLabel('after_link'),
                                'data-content' => $model->getAttributeDescription('after_link'),
                            ],
                        ],
                    ]
                ); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <?= $form->textFieldGroup(
                    $model,
                    'target',
                    [
                        'widgetOptions' => [
                            'data' => $model->getStatusList(),
                            'htmlOptions' => [
                                'class' => 'popover-help',
                                'data-original-title' => $model->getAttributeLabel('target'),
                                'data-content' => $model->getAttributeDescription('target'),
                            ],
                        ],
                    ]
                ); ?>
            </div>
            <div class="col-sm-4">
                <?= $form->textFieldGroup(
                    $model,
                    'rel',
                    [
                        'widgetOptions' => [
                            'data' => $model->getStatusList(),
                            'htmlOptions' => [
                                'class' => 'popover-help',
                                'data-original-title' => $model->getAttributeLabel('rel'),
                                'data-content' => $model->getAttributeDescription('rel'),
                            ],
                        ],
                    ]
                ); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <?= $form->dropDownListGroup(
                    $model,
                    'condition_name',
                    [
                        'widgetOptions' => [
                            'data' => $model->getConditionList(),
                            'htmlOptions' => [
                                'class' => 'popover-help',
                                'data-original-title' => $model->getAttributeLabel('condition_name'),
                                'data-content' => $model->getAttributeDescription('condition_name'),
                                'empty' => '',
                            ],
                        ],
                    ]
                ); ?>
            </div>
            <div class="col-sm-3">
                <?= $form->dropDownListGroup(
                    $model,
                    'condition_denial',
                    [
                        'widgetOptions' => [
                            'data' => $model->getConditionDenialList(),
                            'htmlOptions' => [
                                'class' => 'popover-help',
                                'data-original-title' => $model->getAttributeLabel('condition_denial'),
                                'data-content' => $model->getAttributeDescription('condition_denial'),
                            ],
                        ],
                    ]
                ); ?>
            </div>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h4 class="modal-title"><?= Yii::t('MenuModule.menu', 'Select link') ?></h4>
            </div>
            <div class="modal-body container">

                <div class="row">
                    <div class="col-sm-6">

                        <div class="row">
                            <div class="col-sm-6">
                                <?= $form->dropDownListGroup($model, 'entity_module_name', [
                                    'widgetOptions' => [
                                        'data' => Yii::app()->menu->getModuleList(),
                                        'htmlOptions' => [
                                            'empty' => Yii::t('MenuModule.menu', '-- Not set --')
                                        ]
                                    ]
                                ]) ?>
                            </div>

                            <div class="col-sm-6">
                                <?= $form->dropDownListGroup($model, 'entity_name', [
                                    'widgetOptions' => [
                                        'data' => Yii::app()->menu->getEntityList($model->entity_module_name),
                                        'htmlOptions' => [
                                            'empty' => Yii::t('MenuModule.menu', '-- Not set --')
                                        ]
                                    ]
                                ]) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <?= $form->labelEx($model, 'entity_id'); ?>
                                <?php $this->widget('bootstrap.widgets.TbSelect2', [
                                        'model' => $model,
                                        'attribute' => 'entity_id',
                                        'data' => Yii::app()->menu->getEntityItemList($model->entity_module_name, $model->entity_name),
                                        'options' => [
                                            'placeholder' => Yii::t('MenuModule.menu', '-- Not set --'),
                                            'width' => '100%'
                                        ],
                                    ]
                                ); ?>
                                <?= $form->error($model, 'entity_id') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" type="button"
                        data-dismiss="modal"><?= Yii::t('MenuModule.menu', 'Close') ?></button>
            </div>
        </div>
    </div>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => $model->getIsNewRecord() ? Yii::t('MenuModule.menu', 'Create menu item and continue') : Yii::t(
            'MenuModule.menu',
            'Save menu item and continue'
        ),
    ]
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label' => $model->getIsNewRecord() ? Yii::t('MenuModule.menu', 'Create menu item and close') : Yii::t(
            'MenuModule.menu',
            'Save menu item and close'
        ),
    ]
); ?>

<?php $this->endWidget(); ?>

<script type="text/javascript">

    var clearEntityIdSelect = function () {
        $('#MenuItem_entity_id').select2('data', null);
        $('#MenuItem_entity_id option').remove();
    };

    $('#MenuItem_entity_module_name').on('change', function () {
        $('#MenuItem_entity_name option').remove();
        clearEntityIdSelect();

        $.post('<?= Yii::app()->createUrl('/menu/menuitemBackend/getentities/') ?>', {
                '<?= Yii::app()->getRequest()->csrfTokenName;?>': '<?= Yii::app()->getRequest()->csrfToken;?>',
                entity_module_name: $(this).val()
            }, function (data) {
                $('#MenuItem_entity_name').append($("<option></option>").attr("value", '').text('-- Не выбрано --'));
                $.each($.parseJSON(data), function (key, value) {
                    $('#MenuItem_entity_name').append($("<option></option>").attr("value", key).text(value));
                });
            }
        );
    });


    $('#MenuItem_entity_name').on('change', function () {
        clearEntityIdSelect();

        $.post('<?= Yii::app()->createUrl('/menu/menuitemBackend/getentityitems/') ?>', {
            '<?= Yii::app()->getRequest()->csrfTokenName;?>': '<?= Yii::app()->getRequest()->csrfToken;?>',
            entity_module_name: $('#MenuItem_entity_module_name').val(), entity_name: $(this).val()
        }, function (data) {
            $.each($.parseJSON(data), function (key, value) {
                $('#MenuItem_entity_id').append($("<option></option>").attr("value", key).text(value));
            });
        });

    });


    $('#MenuItem_entity_id').on('select2-selecting', function (e) {

        $.post('<?= Yii::app()->createUrl('/menu/menuitemBackend/getentityurl/') ?>', {
            '<?= Yii::app()->getRequest()->csrfTokenName;?>': '<?= Yii::app()->getRequest()->csrfToken;?>',
            entity_module_name: $('#MenuItem_entity_module_name').val(),
            entity_name: $('#MenuItem_entity_name').val(),
            entity_id: e.val

        }, function (data) {
                $('#MenuItem_href').val(data);
            }
        );


    });
</script>