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
?>

<?php $this->widget('application.modules.yupe.widgets.YFlashMessages'); ?>
<?php $form = $this->beginWidget('CActiveForm', array('id' => 'registration-form'));?>
<?php echo $form->errorSummary($model); ?>
<div class="form_reg_edit">
<?php 
if(!$this->module->autoNick)
{
?>
    <div class="list">
        <div class="name"><?php echo $form->labelEx($model, 'nick_name'); ?></div>
        <div class="form"><?php echo $form->textField($model, 'nick_name');?>
             <br /><?php echo "<small>".Yii::t('user','Имя пользователя и пароль должны содержать только латинские буквы и цифры.')."</small>"; ?>
        </div>
        <div class="accession"><?php echo $form->error($model, 'nick_name'); ?></div>
    </div>
<?php
}
?>
    <div class="list">
        <div class="name"><?php echo $form->labelEx($model, 'last_name'); ?></div>
        <div class="form"><?php echo $form->textField($model, 'last_name');?></div>
        <div class="accession"><?php echo $form->error($model, 'last_name'); ?></div>
    </div>
    <div class="list">
        <div class="name"><?php echo $form->labelEx($model, 'first_name'); ?></div>
        <div class="form"><?php echo $form->textField($model, 'first_name');?></div>
        <div class="accession"><?php echo $form->error($model, 'first_name'); ?></div>
    </div>
    <div class="list">
        <div class="name"><?php echo $form->labelEx($model, 'middle_name'); ?></div>
        <div class="form"><?php echo $form->textField($model, 'middle_name');?></div>
        <div class="accession"><?php echo $form->error($model, 'middle_name'); ?></div>
    </div>

    <div class="list">
        <div class="name"><?php echo $form->labelEx($model, 'email'); ?></div>
        <div class="form"><?php echo $form->textField($model, 'email',array('style'=>'border: 1px solid '.(Yii::app()->user->profile->email_confirm?"#88d395":"#fcc")));?><br />
            <?php
            if (Yii::app()->user->profile->email_confirm)
                echo "<small>".Yii::t('user','Внимание! После смены e-mail адреса, вам будет выслано письмо для его подтверждения.')."</small>";
            else
                echo "<span class='required'>".Yii::t('user','e-mail не подтвержден, проверьте почту!')."</span>";
         ?>
        </div>
        <div class="accession">
            <?php
            if (Yii::app()->user->profile->email_confirm)
                echo "<small><br /><span style='color:#88d395;'>".Yii::t('user',"E-Mail проверен")."</span></small><br />";
            echo $form->error($model, 'email'); ?>
        </div>
    </div>
    <div class="list">
        <div class="name"><?php echo $form->labelEx($model, 'birth_date'); ?></div>
        <div class="form"><?php
            if ($model->birth_date) $model->birth_date= Yii::app()->dateFormatter->formatDateTime(strtotime($model->birth_date),"medium",null);
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model'=>$model,            
            'attribute' => 'birth_date',
            'language' => Yii::app()->language,
        )); ?></div>
        <div class="accession"><?php echo $form->error($model, 'birth_date'); ?></div>
    </div>    
    <div class="list">
        <div class="name"><?php echo $form->labelEx($model, 'gender'); ?></div>
        <div class="form"><?php echo $form->dropDownList($model, 'gender', User::model()->getGendersList()); ?></div>
        <div class="accession"><?php echo $form->error($model, 'gender'); ?></div>
    </div>

    <div class="list">
        <div class="name"><?php echo $form->labelEx($model, 'about'); ?></div>
        <div class="form"><?php echo $form->textArea($model, 'about', array('rows'=>3, 'maxlength'=>300));?>
             <br /><?php echo "<small>".Yii::t('user','Напишите несколько слов о себе, своих увлечениях и интересах.')."</small>"; ?>
        </div>
        <div class="accession"><?php echo $form->error($model, 'about'); ?></div>
    </div>

    <div class="list">
        <div class="name"><?php echo $form->labelEx($model, 'password'); ?></div>
        <div class="form"><?php echo $form->passwordField($model, 'password');?></div>
        <div class="accession">
            <?php /* <input type="button" value="Получить" onClick="RandomPasw(this.form)"></div> */?>
            <input type="checkbox" value="1" id='show_pass'/> <?php echo Yii::t('user','не прятать') ?>
            <?php /*echo $form->error($model, 'password'); */?>
        </div><br />
        <div class="name"><?php echo $form->labelEx($model, 'cPassword'); ?></div>
        <div class="form"><?php echo $form->passwordField($model, 'cPassword');?></div>
        <div class="accession"><?php /* echo $form->error($model, 'cPassword'); */?><!-- <input type="button" value="Получить" onClick="RandomPasw(this.form)"> --></div>
    </div>
        <?php
            if (is_array($this->module->profiles)&&count($this->module->profiles))
                foreach($this->module->profiles as $k=>$p)
                   $this->renderPartial("//".$k."/".$k."_profile", array("model"=>$p, "form"=>$form));
        ?>
    <div class="last"><input type="submit" value="<?php echo Yii::t('user','Сохранить профиль')?>" /></div>
</div>
<?php $this->endWidget(); ?>