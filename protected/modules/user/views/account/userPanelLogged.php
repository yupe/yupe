<?php
    /* @var YWebUser $user */
    $user=Yii::app()->user;
?>
<!-- block "user panel" start -->
<div class="panel">
    <div class="user"><?=CHtml::link($user->profile->first_name." ".$user->profile->last_name, array('/user/account/profile'))?></div>
    <div class="mail"><?=CHtml::link($user->email, array('/user/account/profile'))?></div>
    <div class="exit"><?=CHtml::link(Yii::t('user','Выход'), array('/user/account/logout'));?></div>
</div>
<!-- //block "user panel" stop -->
