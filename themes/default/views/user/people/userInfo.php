<?php
    $this->pageTitle = CHtml::encode($user->nick_name);
    $this->breadcrumbs = array(
        Yii::t('user', 'Пользователи') => array('/user/people/index/'),
        CHtml::encode($user->nick_name),
    );
?>

 <div class="row-fluid">
     <div class='span3'>
         <?php $this->widget('AvatarWidget', array('user' => $user)); ?>
     </div>
     <div class='span6'>

         <i class="icon-user"></i> <?php echo $user->getFullName();?><br/>         

         <?php if($user->last_visit):?>
            <i class="icon-time"></i> <?php echo Yii::t('user', 'Был на сайте {last_visit}', array(
               "{last_visit}" => Yii::app()->dateFormatter->formatDateTime($user->last_visit, 'long', null)
            ));?><br/>
         <?php endif;?>   

         <?php if($user->location):?>
            <i class="icon-map-marker"></i> <?php echo $user->location;?><br/>
         <?php endif;?>   

         <?php if($user->site):?>
            <i class="icon-globe"></i> <?php echo CHtml::link($user->site,$user->site, array('rel' => 'nofollow'));?><br/>
         <?php endif;?>

     </div>     
 </div>

<br/>

<?php if($user->online_status):?>
    <blockquote><?php echo CHtml::encode($user->online_status);?></blockquote>
<?php endif;?>

<?php if($user->about):?>            
     <div class="row-fluid">
         <div class="well">
            <p><?php echo CHtml::encode($user->about);?></p>
         </div>
     </div>
<?php endif;?>     

<hr/>

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
    <div class="alert alert-notice">
        Пожалуйста, <?php echo CHtml::link('авторизуйтесь', array('/user/account/login/')); ?> или
        <?php echo CHtml::link('зарегистрируйтесь', array('/user/account/registration/')); ?>
        - только тогда можно писать на моей стене =)
    </div>
<?php endif; ?>