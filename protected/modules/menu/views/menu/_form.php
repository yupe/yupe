<script type='text/javascript'>
    $(document).ready(function(){
        $('#menu-form').liTranslit({
            elName: '#Menu_name',
            elAlias: '#Menu_code'
        });
    })
</script>

<?php
/**
 * Файл представления menu/_form:
 *
 * @category YupeViews
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://yupe.ru
 *
 **/
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
        'id'                     => 'menu-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => array('class' => 'well'),
        'inlineErrors'           => true,
    )
); ?>
    <div class="alert alert-info">
        <?php echo Yii::t('MenuModule.menu', 'Поля, отмеченные'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('MenuModule.menu', 'обязательны.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class="row-fluid control-group <?php echo $model->hasErrors("name") ? "error" : ""; ?>">
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'popover-help span7', 'maxlength' => 255, 'data-original-title' => $model->getAttributeLabel('name'), 'data-content' => $model->getAttributeDescription('name'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors("code") ? "error" : ""; ?>">
        <?php echo $form->textFieldRow($model, 'code', array('class' => 'popover-help span7', 'maxlength' => 255, 'data-original-title' => $model->getAttributeLabel('code'), 'data-content' => $model->getAttributeDescription('code'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors("description") ? "error" : ""; ?>">
        <div class="popover-help" data-original-title='<?php echo $model->getAttributeLabel('description'); ?>' data-content='<?php echo $model->getAttributeDescription('description'); ?>'>
            <?php echo $form->textAreaRow($model, 'description', array('class' => 'span7')); ?>
        </div>
     </div>
     <div class="row-fluid control-group <?php echo $model->hasErrors('status') ? 'error' : '' ?>">
        <?php echo $form->dropDownListRow($model, 'status', $model->statusList, array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('status'), 'data-content' => $model->getAttributeDescription('status'))); ?>
     </div>
    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'type'       => 'primary',
            'label'      => $model->isNewRecord ? Yii::t('MenuModule.menu', 'Добавить меню и продолжить') : Yii::t('MenuModule.menu', 'Сохранить меню и продолжить'),
        )
    ); ?>
    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'buttonType'  => 'submit',
            'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
            'label'       => $model->isNewRecord ? Yii::t('MenuModule.menu', 'Добавить меню и закрыть') : Yii::t('MenuModule.menu', 'Сохранить меню и закрыть'),
        )
    ); ?>

<?php $this->endWidget(); ?>
