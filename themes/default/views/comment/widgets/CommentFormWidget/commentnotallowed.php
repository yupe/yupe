<div class="alert alert-warning">
    <?php echo Yii::t(
        'CommentModule.comment',
        'Please, {login} or {register} for commenting!',
        [
            '{login}'    => CHtml::link(Yii::t('CommentModule.comment', 'login'), ['/user/account/login']),
            '{register}' => CHtml::link(
                    Yii::t('CommentModule.comment', 'register'),
                    ['/user/account/registration']
                )
        ]
    );?>
</div>
