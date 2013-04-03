<?php
    $this->pageTitle = CHtml::encode($user->nick_name);
    $this->breadcrumbs = array(
        Yii::t('user', 'Пользователи') => array('/user/people/index/'),
        CHtml::encode($user->nick_name),
    );
?>
<div style="float:left; margin-right: 20px; height:100px;">
    <?php echo CHtml::image($user->getAvatar(100),$user->nick_name,array('width' => 100, 'height' => 100)); ?>
</div>
<div style="float:left;">
<?php
if (!$this->module->autoNick)
    echo CHtml::openTag("b") . CHtml::encode($user->nick_name) . CHtml::closeTag("b") . "<br />"; ?>
<h1><?php echo $user->getFullName(); ?></h1>

<?php
if ($user->gender)
    echo (($user->gender == User::GENDER_MALE) ? Yii::t("user", "Мужчина") : Yii::t("user", "Женщина")) . ". ";
if ($user->birth_date)
    echo Yii::t('user', 'День рождения: {birth_date}', array("{birth_date}" => Yii::app()->dateFormatter->formatDateTime($user->birth_date, 'short', null)));
?>
<br />
<?php
if ($user->last_visit)
    echo Yii::t('user', 'Последний раз был на сайте {last_visit}', array(
        "{last_visit}" => Yii::app()->dateFormatter->formatDateTime($user->last_visit, 'long', null)
    ));
if ($user->location)
    echo "<br />" . Yii::t('user', 'Откуда: {location}', array("{location}" => $user->location));
?>
</div>
<br clear="all"/><br />
<?php if($user->about) echo "<small>О себе:</small><br /><cite>".CHtml::encode($user->about)."</cite>" ?>
<br/><br/><br/>

<?php $this->widget('application.modules.comment.widgets.CommentsListWidget', array(
    'label' => 'Мнений',
    'model' => $user,
    'modelId' => $user->id,
)); ?>

<br/>

<h3>На моей стене можно что-то написать!</h3>

<?php if(Yii::app()->user->isAuthenticated()): ?>
    <?php $this->widget('application.modules.comment.widgets.CommentFormWidget', array(
        'redirectTo' => $this->createUrl('/user/people/userInfo/', array('username' => $user->nick_name)),
        'model' => $user,
        'modelId' => $user->id,
    )); ?>
<?php else: ?>
    <p>
        Пожалуйста, <?php echo CHtml::link('авторизуйтесь', array('/user/account/login/')); ?> или
        <?php echo CHtml::link('зарегистрируйтесь', array('/user/account/registration/')); ?>
        - только тогда можно писать на моей стене =)
    </p>
<?php endif; ?>