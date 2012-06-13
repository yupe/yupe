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

<br/><br/><br/>

<?php $this->widget('application.modules.comment.widgets.CommentsListWidget', array('label' => 'Мнений','model' => $user, 'modelId' => $user->id)); ?>

<br/>

<h3>На моей стене можно что-то написать!</h3>

<?php if(Yii::app()->user->isAuthenticated()):?>
    <?php $this->widget('application.modules.comment.widgets.CommentFormWidget', array('redirectTo' => $this->createUrl('/user/people/userInfo/', array('username' => $user->nick_name)), 'model' => $user, 'modelId' => $user->id)); ?>
<?php else:?>
    <p>Пожалуйста, <?php echo CHtml::link('авторизуйтесь',array('/user/account/login/'));?> или <?php echo CHtml::link('зарегистрируйтесь',array('/user/account/registration/'));?> - только тогда можно писать на моей стене =)</p>
<?php endif?>