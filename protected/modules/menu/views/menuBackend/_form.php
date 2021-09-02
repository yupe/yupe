<?php
/**
 * Файл представления menu/_form:
 *
 * @category YupeViews
 * @package  yupe
 * @author   YupeTeam <support@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     https://yupe.ru
 *
 * @var $this MenuBackendController
 * @var $model Menu
 * @var $form \yupe\widgets\ActiveForm
 **/
$form = $this->beginWidget(
    'yupe\widgets\ActiveForm',
    [
        'id'                     => 'menu-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'htmlOptions'            => ['class' => 'well'],
    ]
); ?>
<div class="alert alert-info">
    <?=  Yii::t('MenuModule.menu', 'Fields with'); ?>
    <span class="required">*</span>
    <?=  Yii::t('MenuModule.menu', 'are required.'); ?>
</div>

<?=  $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-7">
        <?=  $form->textFieldGroup(
            $model,
            'name',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('name'),
                        'data-content'        => $model->getAttributeDescription('name'),
                    ],
                ],
            ]
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?=  $form->slugFieldGroup(
            $model,
            'code',
            [
                'sourceAttribute' => 'name',
                'widgetOptions'   => [
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('code'),
                        'data-content'        => $model->getAttributeDescription('code'),
                    ],
                ],
            ]
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?=  $form->textAreaGroup(
            $model,
            'description',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('description'),
                        'data-content'        => $model->getAttributeDescription('description'),
                    ],
                ],
            ]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-7">
        <?=  $form->dropDownListGroup(
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

<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => $model->getIsNewRecord() ? Yii::t('MenuModule.menu', 'Create menu and continue') : Yii::t(
            'MenuModule.menu',
            'Save menu and continue'
        ),
    ]
); ?>

<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType'  => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label'       => $model->getIsNewRecord() ? Yii::t('MenuModule.menu', 'Create menu and close') : Yii::t(
            'MenuModule.menu',
            'Save menu and close'
        ),
    ]
); ?>

<?php $this->endWidget(); ?>
