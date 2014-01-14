<div class="alert alert-notice">
    <?php echo Yii::t('CommentModule.comment','Please, {login} or {register} for commenting!', array(
    	'{login}' => CHtml::link(Yii::t('CommentModule.comment','login'), array('/user/account/login')),
    	'{register}' => CHtml::link(Yii::t('CommentModule.comment','register'), array('/user/account/registration'))
    ));?>	
</div>