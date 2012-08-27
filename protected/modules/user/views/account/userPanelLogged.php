<?php
    /* @var YWebUser $user */
    $user=Yii::app()->user;
?>
<!-- block "user panel" start -->
<div class="panel">
    <div class="user"><?php echo CHtml::link($user->profile->first_name." ".$user->profile->last_name, array('/user/account/profile'))?></div>
    <div class="mail"><?php echo CHtml::link($user->email, array('/user/account/profile'))?></div>
    <div class="exit"><?php echo CHtml::link(Yii::t('user','Выход'), array('/user/account/logout'));?></div>
</div>
<!-- //block "user panel" stop -->
