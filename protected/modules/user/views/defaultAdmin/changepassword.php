<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('user')->getCategory() => array(),
        Yii::t('UserModule.user', 'Пользователи') => array('/admin/user'),
        $model->nick_name => array('/admin/user/view', 'id' => $model->id),
        Yii::t('UserModule.user', 'Изменение паролья'),
    );

    $this->pageTitle = Yii::t('UserModule.user', 'Пользователи - изменение пароля');

    $this->menu = array(
        array('label' => Yii::t('UserModule.user', 'Пользователи'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('UserModule.user', 'Управление пользователями'), 'url' => array('/admin/user')),
            array('icon' => 'plus-sign', 'label' => Yii::t('UserModule.user', 'Добавление пользователя'), 'url' => array('/admin/user/create')),
            array('label' => Yii::t('UserModule.user', 'Пользователь') . ' «' . $model->nick_name . '»'),
            array('icon' => 'pencil', 'label' => Yii::t('UserModule.user', 'Редактирование пользователя'), 'url' => array(
                '/admin/user/update',
                'id' => $model->id
            )),
            array('icon' => 'eye-open', 'label' => Yii::t('UserModule.user', 'Просмотр пользователя'), 'url' => array(
                '/admin/user/view',
                'id' => $model->id
            )),
            array('icon' => 'lock', 'label' => Yii::t('UserModule.user', 'Изменить пароль пользователя'), 'url' => array(
                '/admin/user/changepassword',
                'id' => $model->id
            )),
            array('icon' => 'trash', 'label' => Yii::t('UserModule.user', 'Удалить пользователя'), 'url' => '#', 'linkOptions' => array(
                'submit' => array('/admin/user/delete', 'id' => $model->id),
                'confirm' => Yii::t('UserModule.user', 'Вы уверены, что хотите удалить пользователя?')),
            ),
        )),
        array('label' => Yii::t('UserModule.user', 'Восстановления паролей'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('UserModule.user', 'Восстановления паролей'), 'url' => array('/admin/user/recoveryPassword/index')),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('UserModule.user', 'Изменение пароля'); ?><br />
        <small>&laquo;<?php echo $model->nick_name; ?>&raquo;</small>
    </h1>
</div>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'user-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well'),
    'inlineErrors'           => true,
));

Yii::app()->clientScript->registerScript('fieldset', "
    $('document').ready(function () {
        $('.popover-help').popover({ trigger : 'hover', delay : 500 });
    });
");
?>
    <?php echo $form->errorSummary($changePasswordForm); ?>

    <div class="row-fluid control-group <?php echo $model->hasErrors('password') ? 'error' : ''; ?>"> 
        <?php echo $form->passwordFieldRow($changePasswordForm, 'password'); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('cPassword') ? 'error' : ''; ?>"> 
        <?php echo $form->passwordFieldRow($changePasswordForm, 'cPassword'); ?>
    </div>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      =>  Yii::t('UserModule.user', 'Изменить пароль'),
    )); ?>

<?php $this->endWidget(); ?>