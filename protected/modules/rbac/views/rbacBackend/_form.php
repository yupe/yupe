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
    [
        'id'                   => 'auth-item-form',
        'enableAjaxValidation' => false,
        'htmlOptions'          => [
            'class' => 'well',
        ],
    ]
); ?>

<div class="alert alert-info">
    <?php echo Yii::t('RbacModule.rbac', 'Fields marked with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('RbacModule.rbac', 'are required.'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-5">
        <?php echo $form->textFieldGroup($model, 'name'); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-5">
        <?php echo $form->dropDownListGroup(
            $model,
            'type',
            [
                'widgetOptions' => [
                    'data'        => $model->getTypeList(),
                    'htmlOptions' => ['empty' => '---'],
                ],
            ]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-5">
        <?php echo $form->textFieldGroup($model, 'description'); ?>
    </div>
</div>

<div id="operations-list" style="display:none;">
    <p><b><?php echo Yii::t('RbacModule.rbac', 'Operations') ?>:</b></p>

    <div class="row">
        <div class="col-sm-5">
            <?php echo CHtml::textField(
                'search',
                '',
                ['class' => 'form-control', 'placeholder' => Yii::t('RbacModule.rbac', 'Filter')]
            ); ?>
        </div>
    </div>
    <p>
        <?php echo CHtml::link(Yii::t('RbacModule.rbac', 'Select all'), '#', ['id' => 'check-all']); ?>
        <?php echo CHtml::link(Yii::t('RbacModule.rbac', 'Clear all'), '#', ['id' => 'uncheck-all']); ?>
    </p>
    <?php foreach ($operations as $k => $v): { ?>
        <div class="row operation">
            <div class="col-sm-7">
                <div class="checkbox">
                    <label>
                        <?php echo CHtml::checkBox(
                            'ChildAuthItems[]',
                            isset($checkedList[$k]),
                            ['class' => 'item', 'value' => $k, 'id' => $k]
                        ); ?>
                        <?php echo $v; ?>
                    </label>
                </div>
            </div>
        </div>
    <?php } endforeach; ?>
</div>

<div id="tasks-list" style="display:none;">
    <p><b>Задачи:</b></p>
    <?php foreach ($tasks as $k => $v): { ?>
        <div class="row operation">
            <div class="col-sm-7">
                <div class="checkbox">
                    <label>
                        <?php echo CHtml::checkBox(
                            'ChildAuthItems[]',
                            isset($checkedList[$k]),
                            ['class' => 'item', 'value' => $k, 'id' => $k]
                        ); ?>
                        <?php echo $v; ?>
                    </label>
                </div>
            </div>
        </div>
    <?php } endforeach; ?>
</div>

<div id="roles-list" style="display:none;">
    <p><b>Роли:</b></p>
    <?php foreach ($roles as $k => $v): { ?>
        <div class="row operation">
            <div class="col-sm-7">
                <div class="checkbox">
                    <label>
                        <?php echo CHtml::checkBox(
                            'ChildAuthItems[]',
                            isset($checkedList[$k]),
                            ['class' => 'item', 'value' => $k, 'id' => $k]
                        ); ?>
                        <?php echo $v; ?>
                    </label>
                </div>
            </div>
        </div>
    <?php } endforeach; ?>
</div>

<br/>

<div class="row">
    <div class="col-sm-5">
        <?php echo $form->textFieldGroup($model, 'bizrule'); ?>
    </div>
</div>

<?php //echo $form->textAreaGroup($model, 'data'); ?>

<br/>

<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('RbacModule.blog', 'Создать') : Yii::t('RbacModule.rbac', 'Save'),
    ]
);
?>

<?php $this->endWidget(); ?>
