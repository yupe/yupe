<?php
    $this->pageTitle = CHtml::encode($user->nick_name);
    $this->breadcrumbs = array(
        Yii::t('UserModule.user','Users') => array('/user/people/index/'),
        CHtml::encode($user->getfullName()),
    );
?>

 <div class="row-fluid">
     <div class='span3'>
         <?php $this->widget('AvatarWidget', array('user' => $user)); ?>
     </div>
     <div class='span6'>

         <i class="icon-user"></i> <?php echo CHtml::link($user->getFullName(), array('/user/people/userInfo/', 'username' => $user->nick_name)); ?><br/>

         <?php if($user->last_visit):?>
            <i class="icon-time"></i> <?php echo Yii::t('UserModule.user', 'Last visit {last_visit}', array(
               "{last_visit}" => Yii::app()->dateFormatter->formatDateTime($user->last_visit, 'long', null)
            ));?><br/>
         <?php endif;?>   

         <?php if($user->location):?>
            <i class="icon-map-marker"></i> <?php echo $user->location;?><br/>
         <?php endif;?>   

         <?php if($user->site):?>
            <i class="icon-globe"></i> <?php echo CHtml::link($user->site,$user->site, array('rel' => 'nofollow', 'target' => '_blank'));?><br/>
         <?php endif;?>

     </div>     
 </div>

<?php if($user->about):?>            
     <div class="row-fluid">
         <div class="well">
            <?php echo $user->about; ?>
         </div>
     </div>
<?php endif;?>     

<hr/>

<?php $this->widget('application.modules.comment.widgets.CommentsListWidget', array(
    'label' => Yii::t('UserModule.user', 'Opinions'),
    'model' => $user,
    'modelId' => $user->id,
)); ?>

<br/>

<h3><?php echo Yii::t('UserModule.user', 'You can write something on my wall'); ?></h3>

<?php if(Yii::app()->user->isAuthenticated()): ?>
    <?php $this->widget('application.modules.comment.widgets.CommentFormWidget', array(
        'redirectTo' => $this->createUrl('/user/people/userInfo/', array('username' => $user->nick_name)),
        'model' => $user,
        'modelId' => $user->id,
    )); ?>
<?php else: ?>
    <div class="alert alert-notice">
        <?php echo Yii::t('UserModule.user', 'Please,').' '; echo CHtml::link(Yii::t('UserModule.user', 'sign in'), array('/user/account/login/')); echo ' '.Yii::t('UserModule.user', 'or').' '; ?>
        <?php echo CHtml::link(Yii::t('UserModule.user', 'sign up'), array('/user/account/registration/')); ?>
        <?php echo ' '.Yii::t('UserModule.user', '- only authorized users can write on my wall =)'); ?>
    </div>
<?php endif; ?>