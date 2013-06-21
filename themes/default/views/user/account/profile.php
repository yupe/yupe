<?php
$this->pageTitle = Yii::t('user', 'Профиль пользователя');

Yii::app()->clientScript->registerScript('regs', "
            $(document).ready(
                function() {
                 $('#show_pass').click( function() {
                      $('#ProfileForm_password').prop('type', $(this).prop('checked')?'text':'password');
                      $('#ProfileForm_cPassword').prop('type', $(this).prop('checked')?'text':'password');
                 });
                }
            );
            ");

$form = $this->beginWidget('CActiveForm', array(
        'id'                     => 'profile-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
    ));
?>
    <h2><?php echo Yii::t('tenders','Учетные данные профиля');?></h2>


        <div class="control-group <?=$model->hasErrors('last_name')?'error':''?>">
            <?php echo $form->labelEx($model, 'last_name',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'last_name') ?>
                <span class="help-inline"><?php echo $form->error($model, 'last_name'); ?></span>
            </div>
        </div>
        <div class="control-group <?=$model->hasErrors('first_name')?'error':''?>">
            <?php echo $form->labelEx($model, 'first_name',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'first_name') ?>
                <span class="help-inline"><?php echo $form->error($model, 'first_name'); ?></span>
            </div>
        </div>
        <div class="control-group <?=$model->hasErrors('middle_name')?'error':''?>">
            <?php echo $form->labelEx($model, 'middle_name',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model, 'middle_name') ?>
                <span class="help-inline"><?php echo $form->error($model, 'middle_name'); ?></span>
            </div>
        </div>
        <div class="control-group <?=$model->hasErrors('email')?'error':''?>">
        <?php echo $form->labelEx($model, 'email'); ?>
        <?php echo $form->textField($model, 'email',array('style'=>'border: 1px solid '.(Yii::app()->user->profile->email_confirm?"#88d395":"#fcc")));?>
            <span class="help-inline">
<?php
            if (Yii::app()->user->profile->email_confirm)
                echo "<small><span style='color:#88d395;'>".Yii::t('user',"E-Mail проверен")."</span></small><br />";
            else
                echo "<span class='required'>".Yii::t('user','e-mail не подтвержден, проверьте почту!')."</span>";

            echo $form->error($model, 'email'); ?>
            </span>
       </div>
                <div class="clearfix"><!-- --></div>
<?php
if (Yii::app()->user->profile->email_confirm)
    echo "<small>".Yii::t('user','Внимание! После смены e-mail адреса, вам будет выслано письмо для его подтверждения.')."</small><br /><br />";

echo "<small>".Yii::t('user','Если вы не желаете менять пароль &ndash; не заполняйте следующие два поля.')."</small><br /><br />";
?>

<div class="control-group <?=$model->hasErrors('password')?'error':''?>">
    <?php echo $form->labelEx($model, 'password',array('class'=>'control-label')); ?>
    <div class="controls">
        <?php echo $form->passwordField($model, 'password', array('class'=>'span3'));?>
        <input type="checkbox" value="1" id='show_pass'/> <?php echo Yii::t('user','не прятать') ?>
    </div>
</div>
<div class="control-group <?=$model->hasErrors('cPassword')?'error':''?>">
    <?php echo $form->labelEx($model, 'cPassword',array('class'=>'control-label')); ?>
    <div class="controls">
        <?php echo $form->passwordField($model, 'cPassword', array('class'=>'span3'));?>
    </div>
</div>
    <?php
    if (is_array($this->module->profiles)&&count($this->module->profiles))
        foreach($this->module->profiles as $k=>$p)
            $this->renderPartial("//".$k."/".$k."_profile", array("model"=>$p, "form"=>$form));

    echo CHtml::submitButton(Yii::t('user','Сохранить профиль'));
    $this->endWidget();?>