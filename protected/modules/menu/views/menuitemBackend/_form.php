<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'id'                     => 'menu-item-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => ['class' => 'well'],
    ]
); ?>
<div class="alert alert-info">
    <?php echo Yii::t('MenuModule.menu', 'Fields with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('MenuModule.menu', 'are required.'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <?php
    $menu_id = '#' . CHtml::activeId($model, 'menu_id');
    $parent_id = '#' . CHtml::activeId($model, 'parent_id');
    ?>
    <div class="col-sm-3">
        <?php echo $form->dropDownListGroup(
            $model,
            'menu_id',
            [
                'widgetOptions' => [
                    'data'        => CHtml::listData(Menu::model()->findAll(), 'id', 'name'),
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('menu_id'),
                        'data-content'        => $model->getAttributeDescription('menu_id'),
                        'empty'               => Yii::t('MenuModule.menu', '--choose menu--'),
                        'ajax'                => [
                            'type'       => 'POST',
                            'url'        => $this->createUrl(
                                    '/menu/menuitemBackend/dynamicparent',
                                    (!$model->isNewRecord ? ['id' => $model->id] : [])
                                ),
                            'update'     => $parent_id,
                            'beforeSend' => "function () {
                            $('" . $parent_id . "').attr('disabled', true);
                            if ($('" . $menu_id . " option:selected').val() == '')
                                return false;
                        }",
                            'complete'   => "function () {
                            $('" . $parent_id . "').attr('disabled', false);
                        }",
                        ],
                    ],
                ],
            ]
        ); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $form->dropDownListGroup(
            $model,
            'parent_id',
            [
                'widgetOptions' => [
                    'data'        => $model->getParentTree(),
                    'htmlOptions' => [
                        'disabled'            => ($model->menu_id) ? false : true,
                        'encode'              => false,
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('parent_id'),
                        'data-content'        => $model->getAttributeDescription('parent_id'),
                    ],
                ],
            ]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup(
            $model,
            'title',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('title'),
                        'data-content'        => $model->getAttributeDescription('title'),
                    ],
                ],
            ]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->checkBoxGroup(
            $model,
            'regular_link',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('regular_link'),
                        'data-content'        => $model->getAttributeDescription('regular_link'),
                    ],
                ],
            ]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup(
            $model,
            'href',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('href'),
                        'data-content'        => $model->getAttributeDescription('href'),
                    ],
                ],
            ]
        ); ?>
    </div>
</div>

<div class="row hidden">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'sort'); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-2">
        <?php echo $form->dropDownListGroup(
            $model,
            'status',
            [
                'widgetOptions' => [
                    'data'        => $model->getStatusList(),
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('status'),
                        'data-content'        => $model->getAttributeDescription('status'),
                    ],
                ],
            ]
        ); ?>
    </div>
</div>

<?php $collapse = $this->beginWidget('booster.widgets.TbCollapse'); ?>
<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                    <?php echo Yii::t('MenuModule.menu', 'Extended settings'); ?>
                </a>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-7">
                        <?php echo $form->textFieldGroup(
                            $model,
                            'title_attr',
                            [
                                'widgetOptions' => [
                                    'data'        => $model->getStatusList(),
                                    'htmlOptions' => [
                                        'class'               => 'popover-help',
                                        'data-original-title' => $model->getAttributeLabel('title_attr'),
                                        'data-content'        => $model->getAttributeDescription('title_attr'),
                                    ],
                                ],
                            ]
                        ); ?>
                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-7">
                        <?php echo $form->textFieldGroup(
                            $model,
                            'class',
                            [
                                'widgetOptions' => [
                                    'data'        => $model->getStatusList(),
                                    'htmlOptions' => [
                                        'class'               => 'popover-help',
                                        'data-original-title' => $model->getAttributeLabel('class'),
                                        'data-content'        => $model->getAttributeDescription('class'),
                                    ],
                                ],
                            ]
                        ); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <?php echo $form->textFieldGroup(
                            $model,
                            'before_link',
                            [
                                'widgetOptions' => [
                                    'data'        => $model->getStatusList(),
                                    'htmlOptions' => [
                                        'class'               => 'popover-help',
                                        'data-original-title' => $model->getAttributeLabel('before_link'),
                                        'data-content'        => $model->getAttributeDescription('before_link'),
                                    ],
                                ],
                            ]
                        ); ?>
                    </div>
                    <div class="col-sm-4">
                        <?php echo $form->textFieldGroup(
                            $model,
                            'after_link',
                            [
                                'widgetOptions' => [
                                    'data'        => $model->getStatusList(),
                                    'htmlOptions' => [
                                        'class'               => 'popover-help',
                                        'data-original-title' => $model->getAttributeLabel('after_link'),
                                        'data-content'        => $model->getAttributeDescription('after_link'),
                                    ],
                                ],
                            ]
                        ); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <?php echo $form->textFieldGroup(
                            $model,
                            'target',
                            [
                                'widgetOptions' => [
                                    'data'        => $model->getStatusList(),
                                    'htmlOptions' => [
                                        'class'               => 'popover-help',
                                        'data-original-title' => $model->getAttributeLabel('target'),
                                        'data-content'        => $model->getAttributeDescription('target'),
                                    ],
                                ],
                            ]
                        ); ?>
                    </div>
                    <div class="col-sm-4">
                        <?php echo $form->textFieldGroup(
                            $model,
                            'rel',
                            [
                                'widgetOptions' => [
                                    'data'        => $model->getStatusList(),
                                    'htmlOptions' => [
                                        'class'               => 'popover-help',
                                        'data-original-title' => $model->getAttributeLabel('rel'),
                                        'data-content'        => $model->getAttributeDescription('rel'),
                                    ],
                                ],
                            ]
                        ); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <?php echo $form->dropDownListGroup(
                            $model,
                            'condition_name',
                            [
                                'widgetOptions' => [
                                    'data'        => $model->getConditionList(),
                                    'htmlOptions' => [
                                        'class'               => 'popover-help',
                                        'data-original-title' => $model->getAttributeLabel('condition_name'),
                                        'data-content'        => $model->getAttributeDescription('condition_name'),
                                        'empty'               => '',
                                    ],
                                ],
                            ]
                        ); ?>
                    </div>
                    <div class="col-sm-3">
                        <?php echo $form->dropDownListGroup(
                            $model,
                            'condition_denial',
                            [
                                'widgetOptions' => [
                                    'data'        => $model->getConditionDenialList(),
                                    'htmlOptions' => [
                                        'class'               => 'popover-help',
                                        'data-original-title' => $model->getAttributeLabel('condition_denial'),
                                        'data-content'        => $model->getAttributeDescription('condition_denial'),
                                    ],
                                ],
                            ]
                        ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('MenuModule.menu', 'Create menu item and continue') : Yii::t(
                'MenuModule.menu',
                'Save menu item and continue'
            ),
    ]
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType'  => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label'       => $model->isNewRecord ? Yii::t('MenuModule.menu', 'Create menu item and close') : Yii::t(
                'MenuModule.menu',
                'Save menu item and close'
            ),
    ]
); ?>

<?php $this->endWidget(); ?>
