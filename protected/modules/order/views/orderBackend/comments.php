<?php
/* @var $this CommentsWidget */
/* @var $form TbActiveForm */
/* @var $model Comment */
/* @var $spamField string */
/* @var $spamFieldValue string */
/* @var $redirectTo string */
/* @var $comments Comment[] */

Yii::app()->clientScript
    ->registerScriptFile(Yii::app()->getModule('comment')->getAssetsUrl() . '/js/comments.js')
    ->registerScript(
        __FILE__,
        "$(document).ready(function(){
        $(document).on('focus', '#Comment_text, div.redactor-editor', function() {
            $('#$spamField').val('$spamFieldValue');
        })
    });"
    );
?>

<div class="comments-widget" id="comments">

    <?php if ($this->showComments): ?>
        <?php if (empty($comments)): ?>
            <p><?= Yii::t('CommentModule.comment', 'Be first!'); ?></p>
        <?php else: ?>
            <h2>
                <small>
                    <?= Yii::t('CommentModule.comment', 'Comments') . ' ' . count($comments); ?>
                    <?= CHtml::link(
                        CHtml::image(Yii::app()->getTheme()->getAssetsUrl() . "/images/rss.png"),
                        [
                            '/comment/commentRss/feed',
                            'model' => get_class($this->model),
                            'modelId' => $this->model->id
                        ]
                    ); ?>
                </small>
            </h2>

            <div class="comments-list">
            <?php foreach ($comments as $comment): ?>
                <?php $this->render('application.modules.order.views.orderBackend._comment', ['comment' => $comment]) ?>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($this->showForm): ?>
        <?php if (!$this->isAllowed()): ?>
            <div class="alert alert-warning">
                <?= Yii::t(
                    'CommentModule.comment',
                    'Please, {login} or {register} for commenting!',
                    [
                        '{login}' => CHtml::link(Yii::t('CommentModule.comment', 'login'), ['/user/account/login']),
                        '{register}' => CHtml::link(
                            Yii::t('CommentModule.comment', 'register'),
                            ['/user/account/registration']
                        )
                    ]
                ); ?>
            </div>
        <?php else: ?>
            <div class="comment-form-wrap">
                <hr/>
                <?php $form = $this->beginWidget(
                    'bootstrap.widgets.TbActiveForm',
                    [
                        'action' => Yii::app()->createUrl('/comment/add/'),
                        'id' => 'comment-form',
                        'type' => 'vertical',
                        'enableAjaxValidation' => true,
                        'enableClientValidation' => true,
                        'htmlOptions' => [
                            'class' => 'well',
                        ]
                    ]
                ); ?>

                <?= $form->errorSummary($model); ?>
                <?= $form->hiddenField($model, 'model'); ?>
                <?= $form->hiddenField($model, 'model_id'); ?>
                <?= $form->hiddenField($model, 'parent_id'); ?>
                <?= CHtml::hiddenField('redirectTo', $redirectTo); ?>

                <?= $form->textField($model, 'spamField', [
                    'name' => $spamField,
                    'style' => 'position:absolute;display:none;visibility:hidden;',
                ]); ?>

                <?= $form->textField($model, 'comment', [
                    'style' => 'position:absolute;display:none;visibility:hidden;'
                ]); ?>

                <?php if (!Yii::app()->getUser()->isAuthenticated()) : ?>
                    <div class='row'>
                        <div class="col-sm-6">
                            <?= $form->textFieldGroup($model, 'name'); ?>
                        </div>
                    </div>

                    <div class='row'>
                        <div class="col-sm-6">
                            <?= $form->textFieldGroup($model, 'email'); ?>
                        </div>
                    </div>

                    <div class='row'>
                        <div class="col-sm-6">
                            <?= $form->textFieldGroup($model, 'url'); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class='row'>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <?= $form->labelEx($model, 'text'); ?>
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
                            <?= $form->error($model, 'text'); ?>
                        </div>
                    </div>
                </div>

                <?php if ($module->showCaptcha && Yii::app()->getUser()->getIsGuest()): ?>
                    <?php if (CCaptcha::checkRequirements()) : ?>
                        <div class="row">
                            <div class="col-sm-4 form-group">
                                <?php $this->widget(
                                    'CCaptcha',
                                    [
                                        'showRefreshButton' => true,
                                        'imageOptions' => [
                                            'width' => '150',
                                        ],
                                        'buttonOptions' => [
                                            'class' => 'btn btn-info',
                                            'id' => 'captcha-refresh'
                                        ],
                                        'buttonLabel' => '<i class="glyphicon glyphicon-repeat"></i>',
                                        'captchaAction' => '/comment/comment/captcha'
                                    ]
                                ); ?>
                            </div>
                        </div>
                        <div class='row'>
                            <div class="col-sm-5">
                                <?= $form->textFieldGroup(
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
                    <?php endif; ?>
                <?php endif; ?>
                <div class="row">
                    <div class="col-sm-12">
                        <button class="btn btn-primary" id="add-comment" type="submit" name="add-comment">
                            <i class="glyphicon glyphicon-comment"></i>
                            <?= Yii::t('CommentModule.comment', 'Create comment'); ?>
                        </button>
                        <button class="btn btn-default" id="close-comment" type="button" style="display: none">
                            <?= Yii::t('CommentModule.comment', 'Отмена'); ?>
                        </button>
                    </div>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
