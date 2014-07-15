<script type="text/javascript">
    $(document).ready(function () {
        jQuery.expr[":"].Contains = jQuery.expr.createPseudo(function (arg) {
            return function (elem) {
                return jQuery(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0;
            };
        });

        $('#AuthItem_type').change(function () {
            var val = parseInt($(this).val());
            $('#operations-list, #tasks-list, #roles-list').hide();
            if (val == <?php echo AuthItem::TYPE_OPERATION;?>) {
                $('#operations-list').show();
            }
            if (val == <?php echo AuthItem::TYPE_TASK;?>) {
                $('#operations-list').show();
                $('#tasks-list').show();
            }
            if (val == <?php echo AuthItem::TYPE_ROLE;?>) {
                $('#operations-list').show();
                $('#tasks-list').show();
                $('#roles-list').show();
            }
        });
        $('#AuthItem_type').change();
        $('#search, #search-saved').keypress(function () {
            var data = $(this).val();
            console.log(data);
            if (data) {
                $('.operation').hide();
                $("label:Contains('" + data + "')").parents('.operation').show();
                $('input:checked').parents('.operation').show();
            } else {
                $('.operation').show();
            }
        });

        $('#check-all').click(function (event) {
            event.preventDefault();
            $('.item:visible').attr('checked', true);
        });

        $('#uncheck-all').click(function (event) {
            event.preventDefault();
            $('.item:visible').attr('checked', false);
        });
    });
</script>

<?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id' => 'auth-item-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array(
            'class' => 'well',
        ),
    )
); ?>

<div class="alert alert-info">
    <?php echo Yii::t('RbacModule.rbac', 'Fields marked with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('RbacModule.rbac', 'are required.'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class="row-fluid">
    <?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 64)); ?>
</div>


<div class="row-fluid">
    <?php echo $form->dropDownListRow($model, 'type', $model->getTypeList(), array('empty' => '---', 'class' => 'span5')); ?>
</div>

<div class="row-fluid">
    <?php echo $form->textFieldRow($model, 'description', array('class' => 'span8')); ?>
</div>

<div id="operations-list" style="display:none;">
    <p><b>Операции:</b></p>
    <?php echo CHtml::textField('search', '', array('class' => 'span5', 'placeholder' => Yii::t('RbacModule.rbac','Filter'))); ?>
    <p>
        <?php echo CHtml::link(Yii::t('RbacModule.rbac', 'Select all'), '#', array('id' => 'check-all')); ?>
        <?php echo CHtml::link(Yii::t('RbacModule.rbac', 'Clear all'), '#', array('id' => 'uncheck-all')); ?>
    </p>
    <?php foreach ($operations as $k => $v): ?>
        <div class="row-fluid operation">
            <div class="span7">
                <label class="checkbox">
                    <?php echo CHtml::checkBox('ChildAuthItems[]', isset($checkedList[$k]), array('class' => 'item', 'value' => $k, 'id' => $k)); ?>
                    <?php echo $v;?>
                </label>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div id="tasks-list" style="display:none;">
    <p><b>Задачи:</b></p>
    <?php foreach ($tasks as $k => $v): ?>
        <div class="row-fluid operation">
            <div class="span7">
                <label class="checkbox">
                    <?php echo CHtml::checkBox('ChildAuthItems[]', isset($checkedList[$k]), array('class' => 'item', 'value' => $k, 'id' => $k)); ?>
                    <?php echo $v;?>
                </label>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div id="roles-list" style="display:none;">
    <p><b>Роли:</b></p>
    <?php foreach ($roles as $k => $v): ?>
        <div class="row-fluid operation">
            <div class="span7">
                <label class="checkbox">
                    <?php echo CHtml::checkBox('ChildAuthItems[]', isset($checkedList[$k]), array('class' => 'item', 'value' => $k, 'id' => $k)); ?>
                    <?php echo $v;?>
                </label>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<br/>

<?php echo $form->textFieldRow($model, 'bizrule', array('class' => 'span8')); ?>

<?php //echo $form->textAreaRow($model, 'data', array('rows' => 6, 'cols' => 50, 'class' => 'span8')); ?>

<br/>

<?php
$this->widget(
    'bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? Yii::t('RbacModule.blog', 'Создать') : Yii::t('RbacModule.rbac', 'Save'),
    )
);
?>

<?php $this->endWidget(); ?>
