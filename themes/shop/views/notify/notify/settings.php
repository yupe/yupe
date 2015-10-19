<?php
$this->title = Yii::t('NotifyModule.notify', 'Notify settings');
$this->breadcrumbs = [
    Yii::t('NotifyModule.notify', 'User') => ['/user/profile/profile'],
    $this->title
];

?>
<div class="main__title grid">
    <h1 class="h2"><?= $this->title ?></h1>
</div>
<div class="main__cart-box grid">
    <div class="grid-module-6">
        <?php
        $form = $this->beginWidget('CActiveForm', [
            'id' => 'notify-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'htmlOptions' => [
                'class' => 'well',
            ]
        ]); ?>

        <?= $form->errorSummary($model); ?>
        <div class="fast-order__inputs">
            <?= $form->checkBox($model, 'my_post'); ?>
            <?= $form->labelEx($model, 'my_post'); ?>
            <?= $form->error($model, 'my_post') ?>
        </div>
        <div class="fast-order__inputs">
            <?= $form->checkBox($model, 'my_comment'); ?>
            <?= $form->labelEx($model, 'my_comment'); ?>
            <?= $form->error($model, 'my_comment') ?>
        </div>

        <div class="fast-order__inputs">
            <div class="column grid-module-3">
                <?= CHtml::submitButton(Yii::t('NotifyModule.notify', 'Save'), [
                    'id' => 'login-btn',
                    'class' => 'btn btn_big btn_wide btn_primary'
                ]) ?>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
