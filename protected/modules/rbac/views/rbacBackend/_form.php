<script type="text/javascript">
    $(document).ready(function () {
        $('#AuthItem_type').change(function () {
            var val = parseInt($(this).val());
            $('#operations-list, #tasks-list').hide();
            if (val == <?php echo AuthItem::TYPE_TASK;?>) {
                $('#operations-list').show();
            }
            if (val == <?php echo AuthItem::TYPE_ROLE;?>) {
                $('#tasks-list').show();
            }
        });

        $('#search, #search-saved').keypress(function(){
            var data = $(this).val();
            if(data) {
                $('.operation').hide();
                $("label:contains('" + data + "')").parents('.operation').show();
                $('input:checked').parents('.operation').show();
            }else{
                $('.operation').show();
            }
        });

        $('#check-all').click(function(event){
            event.preventDefault();
            $('.item:visible').attr('checked', true);
        });
    });
</script>

<?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id' => 'auth-item-form',
        'enableAjaxValidation' => false,
    )
); ?>

<div class="alert alert-info">
    <?php echo Yii::t('RbacModule.rbac', 'Поля отмеченные'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('RbacModule.rbac', 'Обязательны.'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<?php if ($model->isNewRecord): ?>
    <?php echo $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 64)); ?>
<?php endif; ?>

<?php if ($model->isNewRecord): ?>
    <?php echo $form->dropDownListRow($model, 'type', $model->getTypeList(), array('empty' => '----','class' => 'span5')); ?>
<?php endif; ?>

<?php echo $form->textFieldRow($model, 'description', array('class' => 'span8')); ?>

<br/><br/>

<?php if ($model->isNewRecord): ?>
    <div id="operations-list" style="display:none;">
       <br/>
       <?php echo CHtml::textField(Yii::t('RbacModule.rbac', 'Искать'), '', array('class' => 'span5', 'placeholder' => 'Фильтр'));?>
       <div><?php echo CHtml::link(Yii::t('RbacModule.rbac', 'Выбрать все'),'#', array('id' => 'check-all'));?></div>
       <?php foreach($operations as $k => $v):?>
         <div class="row-fluid operation" style="width: 30%">
           <div class="span1"><?php echo CHtml::checkBox('operations[]',false,array('class' => 'item', 'value' => $k));?></div>
           <div class="span11"><?php echo CHtml::label($v, $k);?></div>
         </div>
       <?php endforeach;?>
    </div>
<?php elseif ($model->type == AuthItem::TYPE_TASK): ?>
    <div id="operations-list" style="display:inline;">
        <div> <?php echo CHtml::textField('search-saved', '', array('class' => 'span5', 'placeholder' => Yii::t('RbacModule.rbac', 'Фильтр')));?> </div>
        <?php foreach($listModels as $k => $v):?>
            <div class="row-fluid operation" style="width: 30%">
                <div class="span1"><?php echo CHtml::checkBox('operations[]',isset($operations[$k]),array('class' => 'item', 'value' => $k));?></div>
                <div class="span11"><?php echo CHtml::label($v, $k);?></div>
            </div>
        <?php endforeach;?>
    </div>
<?php endif; ?>

<?php if ($model->isNewRecord): ?>
    <div id="tasks-list" style="display:none;">
        <?php foreach($tasks as $k => $v):?>
            <div class="row-fluid operation" style="width: 30%">
                <div class="span1"><?php echo CHtml::checkBox('tasks[]',false,array('class' => 'item', 'value' => $k));?></div>
                <div class="span11"><?php echo CHtml::label($v, $k);?></div>
            </div>
        <?php endforeach;?>
    </div>
<?php elseif ($model->type == AuthItem::TYPE_ROLE): ?>
    <div id="tasks-list" style="display:inline;">
        <?php foreach($listModels as $k => $v):?>
            <div class="row-fluid operation" style="width: 30%">
                <div class="span1"><?php echo CHtml::checkBox('tasks[]',isset($tasks[$k]),array('class' => 'item', 'value' => $k));?></div>
                <div class="span11"><?php echo CHtml::label($v, $k);?></div>
            </div>
        <?php endforeach;?>
    </div>
<?php endif; ?>

<br/><br/>

<?php echo $form->textAreaRow($model, 'bizrule', array('rows' => 6, 'cols' => 50, 'class' => 'span8')); ?>

<?php echo $form->textAreaRow($model, 'data', array('rows' => 6, 'cols' => 50, 'class' => 'span8')); ?>

<br/>

<?php
$this->widget(
    'bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? Yii::t('RbacModule.blog', 'Создать') : Yii::t('RbacModule.rbac', 'Сохранить'),
    )
);
?>

<?php $this->endWidget(); ?>
