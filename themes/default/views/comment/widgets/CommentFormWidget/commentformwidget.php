<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->getModule('comment')->getAssetsUrl().'/js/comments.js');
Yii::app()->clientScript->registerScript(
    'spam-field',
    "$(document).ready(function(){
        $(document).on('focus', '#Comment_text, div.redactor-editor', function(){
            $('#$spamField').val('$spamFieldValue');
        })
    });"
); ?>

<a href='#' id='wcml' style="display: none;"><?php echo Yii::t("CommentModule.comment", 'WRITE COMMENT'); ?></a>

<div id='comment-form-wrap' class='comment-form-wrap'>

    <div id='comment-result' class='alert alert-info' style='display:none'></div>

    <?php $form = $this->beginWidget(
        'bootstrap.widgets.TbActiveForm',
        [
            'action'      => Yii::app()->createUrl('/comment/add/'),
            'id'          => 'comment-form',
            'type'        => 'vertical',
            'enableAjaxValidation' => true,
            'htmlOptions' => [
                'class' => 'well',
            ]
        ]
    ); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->hiddenField($model, 'model'); ?>
    <?php echo $form->hiddenField($model, 'model_id'); ?>
    <?php echo $form->hiddenField($model, 'parent_id'); ?>
    <?php echo CHtml::hiddenField('redirectTo', $redirectTo); ?>

    <?php echo $form->textField($model, 'spamField', [
        'name'  => $spamField,
        'style' => 'position:absolute;display:none;visibility:hidden;',
    ]); ?>

    <?php echo $form->textField($model, 'comment', [
            'style' => 'position:absolute;display:none;visibility:hidden;'
        ]); ?>

    <?php if (!Yii::app()->getUser()->isAuthenticated()) : { ?>
        <div class='row'>
            <div class="col-sm-6">
                <?php echo $form->textFieldGroup($model, 'name'); ?>
            </div>
        </div>

        <div class='row'>
            <div class="col-sm-6">
                <?php echo $form->textFieldGroup($model, 'email'); ?>
            </div>
        </div>

        <div class='row'>
            <div class="col-sm-6">
                <?php echo $form->textFieldGroup($model, 'url'); ?>
            </div>
        </div>
    <?php } endif; ?>

    <div class='row'>
        <div class="col-sm-12">
            <div class="form-group">
                <?php echo $form->labelEx($model, 'text')?>
                <?php $this->widget(
                    $module->getVisualEditor(),
                    [
                        'model' => $model,
                        'attribute' => 'text',
                        'options' => [
                            'rows' => '3',
                        ]
                    ]
                ); ?>
            </div>
        </div>
    </div>

    <?php if ($module->showCaptcha && !Yii::app()->getUser()->isAuthenticated()): { ?>
        <?php if (CCaptcha::checkRequirements()) : { ?>
            <div class="row">
                <div class="col-sm-4 form-group">
                    <?php
                    $this->widget(
                        'CCaptcha',
                        [
                            'showRefreshButton' => true,
                            'imageOptions'      => [
                                'width' => '150',
                            ],
                            'buttonOptions'     => [
                                'class' => 'btn btn-info',
                                'id' => 'captcha-refresh'
                            ],
                            'buttonLabel'       => '<i class="glyphicon glyphicon-repeat"></i>',
                            'captchaAction'     => '/comment/comment/captcha'
                        ]
                    );
                    ?>
                </div>
            </div>
            <div class='row'>
                <div class="col-sm-5">
                    <?php echo $form->textFieldGroup(
                        $model,
                        'verifyCode',
                        [
                            'widgetOptions' => [
                                'htmlOptions' => [
                                    'placeholder' => Yii::t(
                                            'CommentModule.comment',
                                            'Insert symbols you see on picture'
                                        )
                                ],
                            ],
                        ]
                    ); ?>
                </div>
            </div>
        <?php } endif; ?>
    <?php } endif; ?>
    <div class="row">
        <div class="col-sm-12">
            <button class="btn btn-primary" id="add-comment" type="submit" name="add-comment"><i
                    class="glyphicon glyphicon-comment"></i> <?php echo Yii::t(
                    'CommentModule.comment',
                    'Create comment'
                ); ?></button>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div>