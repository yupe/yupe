<?php
    $this->pageTitle = Yii::t('user', 'Регистрация нового пользователя');
    $this->layout="//layouts/contentonly";

    Yii::app()->clientScript->registerScript('regs', "
            $(document).ready(
                function() {
                 $('#show_pass').click( function() {
                      $('#RegistrationForm_password').prop('type', $(this).prop('checked')?'text':'password');
                      $('#RegistrationForm_cPassword').prop('type', $(this).prop('checked')?'text':'password');
                 });

                 $('#agree').click( function() {
                        if (!$(this).prop('checked'))
                            $('#btnsubmit').attr('disabled', 'disabled');
                        else
                            $('#btnsubmit').removeAttr('disabled');

                 });

                }
            );
            ");
?>

    <?php $this->widget('application.modules.yupe.widgets.YFlashMessages'); ?>
    <?php $form = $this->beginWidget('CActiveForm', array('id' => 'registration-form'));?>
    <?php echo $form->errorSummary($model); ?>
        <div class="form_reg_edit">
            <h2>Учетные данные профиля</h2>
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
                <div class="form"><?php echo $form->textField($model, 'email');?></div>
                <div class="accession"><?php echo $form->error($model, 'email'); ?></div>
            </div>

            <div class="list">
                <div class="name"><?php echo $form->labelEx($model, 'password'); ?></div>
                <div class="form"><?php echo $form->passwordField($model, 'password');?></div>
                <div class="accession">
                    <?php /* <input type="button" value="Получить" onClick="RandomPasw(this.form)"></div> */?>
                    <input type="checkbox" value="1" id='show_pass'/> <?php echo Yii::t('user','не прятать'); ?>
                    <?php /*echo $form->error($model, 'password'); */?>
            </div>
            <div class="list">
                <div class="name"><?php echo $form->labelEx($model, 'cPassword'); ?></div>
                <div class="form"><?php echo $form->passwordField($model, 'cPassword');?></div>
                <div class="accession"><?php /* echo $form->error($model, 'cPassword'); */?><!-- <input type="button" value="Получить" onClick="RandomPasw(this.form)"> --></div>
            </div>
            <div class="list">
                <div class="name"></div>
                <div class="full">
                    <input id="agree" name="Agreement" type="checkbox" value="ON" <?php echo isset($_POST['RegistrationForm'])?'checked="checked"':''?> /> <?php echo Yii::t('user','Принимаю <a href="#how_work" name="modal">соглашение</a>.'); ?><br />
                    <!-- <input name="Name" type="checkbox" value="ON" /> Разрешить авторизацию через социальные сервисы. -->
                </div>
            </div>
            <div class="last"><input <?php echo !isset($_POST['RegistrationForm'])?'disabled="disabled"':''?> type="submit" id="btnsubmit" value="<?php echo Yii::t('user','Зарегистрироваться'); ?>" /></div>
        </div>
    <?php $this->endWidget(); ?>
            <div id="mask"></div>
            <!-- block "how work" start -->
            <div id="boxes">
                <div id="how_work" class="window">
                    <div class="title">
                        <h1>Соглашение</h1>
                        <a href="#"class="close"/>Закрыть</a>
                    </div>
                    <p><?php $this->widget("application.modules.contentblock.widgets.ContentBlockWidget", array("code" => "agreement")); ?></p>
                </div>
            </div>
            <!-- //block "how work" stop -->
            <?php
/*

<div class='hint'>Пожалуйста, имя пользователя и пароль заполняйте только латинскими буквами и цифрами.</div>

    <br/><br/>


    <div class="form">


    <div class="row">
        <?php echo $form->labelEx($model, 'nick_name'); ?>
        <?php echo $form->textField($model, 'nick_name') ?>
        <?php echo $form->error($model, 'nick_name'); ?>
    </div>

    <?php if (Yii::app()->getModule('user')->showCaptcha): ?>
    <?php if (extension_loaded('gd')): ?>
        <div class="row">
            <?php echo $form->labelEx($model, 'verifyCode'); ?>
            <div>
                <?php $this->widget('CCaptcha', array('showRefreshButton' => false)); ?>
                <?php echo $form->textField($model, 'verifyCode'); ?>
                <?php echo $form->error($model, 'verifyCode'); ?>
            </div>
            <div class="hint">
                Введите текст указанный на картинке
            </div>
        </div>
        <?php endif; ?>
    <?php endif; ?>



    <div class="row submit">
        <?php echo CHtml::submitButton('Зарегистрироваться'); ?>
    </div>

    </div><!-- form -->

  //  <?php  $this->widget('application.modules.social.extensions.eauth.EAuthWidget',array('action' => '/social/social/login/'));

*/
?>


