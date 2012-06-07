<?php
    $this->pageTitle = CHtml::encode($user->nick_name);
    $this->breadcrumbs = array(
        Yii::t('user', 'Пользователи') => array('/user/people/index/'),
        CHtml::encode($user->nick_name),
    );
?>

<h1><?php echo $user->getFullName();?></h1>

<?php echo CHtml::image($user->getAvatar(100),$user->getFullName())?>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $user,
    'attributes' => array(
        'first_name',
        'last_name',
        'nick_name',
        'location',
        'site',
        'birth_date',
        'about',
        array(
            'name' => 'gender',
            'value' => $user->getGender(),
        ),
        'last_visit',
    ),
));
?>
<br/><br/>
<div style='float:left;padding-right:5px'>
    <?php $this->widget('application.modules.social.widgets.ysc.yandex.YandexShareApi', array(
    'type' => 'button',
    'services' => 'all'
));?>
</div>
