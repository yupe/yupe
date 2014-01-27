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

         <i class="icon-user"></i> <?php echo CHtml::link(CHtml::encode($user->getFullName()), array('/user/people/userInfo/', 'username' => CHtml::encode($user->nick_name))); ?><br/>

         <?php if($user->last_visit):?>
            <i class="icon-time"></i> <?php echo Yii::t('UserModule.user', 'Last visit {last_visit}', array(
               "{last_visit}" => Yii::app()->dateFormatter->formatDateTime($user->last_visit, 'long', null)
            ));?><br/>
         <?php endif;?>   

         <?php if($user->location):?>
            <i class="icon-map-marker"></i> <?php echo CHtml::encode($user->location);?><br/>
         <?php endif;?>   

         <?php if($user->site):?>
            <i class="icon-globe"></i> <?php echo CHtml::link($user->site,$user->site, array('rel' => 'nofollow', 'target' => '_blank'));?><br/>
         <?php endif;?>

     </div>     
 </div>

 <br/>

 <div class="row-fluid">
    <?php if($user->about):?>          
         <blockquote>
            <p><?php echo $user->about; ?></p>
         </blockquote>             
    <?php endif;?> 
 </div>

<br/>

<?php $this->widget('application.modules.blog.widgets.UserBlogsWidget', array(
    'userId' => $user->id
)); ?>


<?php $this->widget('application.modules.blog.widgets.LastPostsWidget', array(
    'view' => 'lastuserposts',
    'criteria' => array(
        'condition' => 'create_user_id = :user_id',
        'params' => array(
            ':user_id' => $user->id
        )
    )
)); ?>


    