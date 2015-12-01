<?php
/* @var $this CommentsWidget */
/* @var $form TbActiveForm */
/* @var $model Comment */
/* @var $spamField string */
/* @var $spamFieldValue string */
/* @var $redirectTo string */
/* @var $comments Comment[] */
/* @var $module CommentModule */

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

<?php if ($this->showComments): ?>
    <div class="product-reviews__body" id="comments">
        <?php if (empty($comments)): ?>
            <p><?= Yii::t('CommentModule.comment', 'Be first!'); ?></p>
        <?php else: ?>
            <?php foreach ($comments as $comment): ?>
                <?php $this->render('_comment', ['comment' => $comment]) ?>
            <?php endforeach; ?>
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
                <div class="product-review-item grid-module-5">
                    <?php $form = $this->beginWidget(
                        'CActiveForm',
                        [
                            'action' => Yii::app()->createUrl('/comment/comment/add/'),
                            'id' => 'comment-form',
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
                        <div class="form-group grid-module-3">
                            <?= $form->labelEx($model, 'name', ['class' => 'form-group__label']); ?>
                            <?= $form->textField($model, 'name', ['class' => 'input']); ?>
                            <?= $form->error($model, 'name'); ?>
                        </div>
                        <div class="form-group grid-module-3">
                            <?= $form->labelEx($model, 'email', ['class' => 'form-group__label']); ?>
                            <?= $form->textField($model, 'email', ['class' => 'input']); ?>
                            <?= $form->error($model, 'email'); ?>
                        </div>
                        <div class="form-group grid-module-3">
                            <?= $form->labelEx($model, 'url', ['class' => 'form-group__label']); ?>
                            <?= $form->textField($model, 'url', ['class' => 'input']); ?>
                            <?= $form->error($model, 'url'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <?= $form->labelEx($model, 'text', ['class' => 'form-group__label']); ?>
                        <?php $this->widget(
                            $module->getVisualEditor(),
                            [
                                'model' => $model,
                                'attribute' => 'text',
                                'options' => [
                                    'rows' => '3',
                                    'class' => 'input',
                                ]
                            ]
                        ); ?>
                        <?= $form->error($model, 'text'); ?>
                    </div>

                    <?php if ($module->showCaptcha && Yii::app()->getUser()->getIsGuest()): ?>
                        <?php if (CCaptcha::checkRequirements()) : ?>
                            <div class="form-group">
                                <?php $this->widget(
                                    'CCaptcha',
                                    [
                                        'showRefreshButton' => true,
                                        'imageOptions' => [
                                            'width' => '150px',
                                            'style' => 'float: left;'
                                        ],
                                        'buttonOptions' => [
                                            'class' => 'btn btn_primary',
                                            'id' => 'captcha-refresh'
                                        ],
                                        'buttonLabel' => '<i class="fa fa-fw fa-repeat"></i>',
                                        'captchaAction' => '/comment/comment/captcha'
                                    ]
                                ); ?>
                            </div>
                            <div class="form-group grid-module-3">
                                <?= $form->textField(
                                    $model,
                                    'verifyCode',
                                    [
                                        'class' => 'input',
                                        'placeholder' => Yii::t(
                                            'CommentModule.comment',
                                            'Insert symbols you see on picture'
                                        )
                                    ]
                                ); ?>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <button class="btn btn_primary" id="add-comment" type="submit" name="add-comment">
                                <i class="fa fa-fw fa-comment"></i>
                                <?= Yii::t('CommentModule.comment', 'Create comment'); ?>
                            </button>
                        </div>
                    </div>
                    <?php $this->endWidget(); ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

    </div>
    <div class="product-reviews__side"><!-- a href="javascript:void(0);" class="btn btn_primary btn_wide">Написать отзыв</a -->
        <div class="product-reviews__stat">Средняя оценка
            <div data-rate='4' class="rating">
                <div class="rating__label">4.2</div>
                <div class="rating__corner">
                    <div class="rating__triangle"></div>
                </div>
            </div>
            <div class="product-reviews__hint">2 оценки</div>
        </div>
    </div>
<?php endif; ?>

