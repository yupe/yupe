<!-- block "user panel" start -->
<div class="panel">
    <div class="global_auth">
        <ul class="loginbox">
            <li class="loginbtn">
                <a class="lbn" id="logbtn" href="#"><img src="<?php echo $base?>/images/browser.png" alt="" border="0" /></a>

                <form method="post" action="">
                    <div id="logform" class="radial">
                        <ul class="reset">

                            <li class="first"><a href="#" class="vk">Вконтакте</a></li>
                            <li class="center"><a href="#" class="fb">Facebook</a></li>
                            <li class="last"><a href="#" class="gl">Google</a></li>

                        </ul>
                        <input name="login" type="hidden" id="login" value="submit" />
                    </div>
                </form>

            </li>
        </ul>
    </div>

    <!--

    По сути, блоки ID = postDiv и ID = postBtn одинаковые. Сначала показывается postDiv,
    после того, как он закроется, показывается postBtn. Ну вот такой уж стрипт получился...

    -->

    <div id="postDiv">
         <?php $form = $this->beginWidget('CActiveForm', array(
                                                         'id' => 'login-form',
                                                         'enableClientValidation' => true,
                                                         'action' => array('/user/account/login/')
                                                    ));?>
            <input name="LoginForm[email]" id="LoginForm[email]" type="text" value="<?php echo Yii::t('tenders','логин');?>" onBlur="if(this.value == '') this.value = 'логин';" onFocus="if(this.value == '<?php echo Yii::t('tenders','логин');?>') this.value = '';" />
            <input name="LoginForm[password]" type="password" />
            <input type="submit" value="<?php echo Yii::t('tenders','Вход');?>" />
        <?php $this->endWidget(); ?>
        <ul>
            <li class="error" id="errorFormq"></li>
            <li><?php echo CHtml::link(Yii::t('tenders','забыли пароль?'),array('/user/account/recovery/'));?></li>
        </ul>
    </div>
    <div id="postBtn" style="display: none;">
        <form method="post" onsubmit="return Check()">
            <input name="login" id="pname" type="text" value="<?php echo Yii::t('tenders','логин');?>" onBlur="if(this.value == '') this.value = 'логин';" onFocus="if(this.value == '<?php echo Yii::t('tenders','логин');?>') this.value = '';" />
            <input name="password" type="password" />
            <input type="submit" value="<?php echo Yii::t('tenders','Вход');?>" />
        </form>
        <ul>
            <li class="error" id="errorFormq"></li>
            <li><?php echo CHtml::link(Yii::t('tenders','забыли пароль?'),array('/user/account/recovery/'));?></li>
        </ul>
    </div>    
</div>
<!-- //block "user panel" stop -->
