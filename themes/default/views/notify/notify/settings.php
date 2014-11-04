<?php
$this->pageTitle = 'Настройки уведомлений';
$this->breadcrumbs = [
    'Профиль пользователя' => ['/user/account/profile'],
    'Настройки уведомлений'
];


$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id' => 'notify-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'type' => 'vertical',
        'htmlOptions' => array(
            'class' => 'well',
        )
    )
);
?>

<?= $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->checkBoxGroup(
                $model,
                'my_post'
            ); ?>
            <?= $form->checkBoxGroup(
                $model,
                'my_comment'
            ); ?>
        </div>
    </div>


    <div class="row">
        <div class="col-xs-12">
            <?php $this->widget(
                'bootstrap.widgets.TbButton',
                array(
                    'buttonType' => 'submit',
                    'context'    => 'primary',
                    'label'      => 'Сохранить',
                )
            ); ?>
        </div>
    </div>


<?php $this->endWidget(); ?>