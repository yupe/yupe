<div class="row-fluid">
    <div class="span2">
        <?php echo CHtml::image($data->getImageUrl(), CHtml::encode($data->name), array('width' => 64, 'height' => 64, 'class' => 'thumbnail')); ?>
    </div>
    <div class="span7 blog-info">
        <?php if(Yii::app()->user->isAuthenticated()):?>
            <?php if(!$data->userIn(Yii::app()->user->getId())):?>
                <a class="btn btn-warning pull-right join-blog" href="<?php echo $data->id;?>"><?php echo Yii::t('BlogModule.blog','Join blog');?></a>
            <?php else:?>
                <a class="btn btn-warning pull-right leave-blog" href="<?php echo $data->id;?>"><?php echo Yii::t('BlogModule.blog','Leave blog');?></a>
            <?php endif;?>
        <?php else:?>
            <a class="btn btn-warning pull-right" href="<?php echo Yii::app()->createUrl('/user/account/login');?>"><?php echo Yii::t('BlogModule.blog','Join blog');?></a>
        <?php endif;?>
        <h2><?php echo CHtml::link(CHtml::encode($data->name), array('/blog/blog/show/', 'slug' => CHtml::encode($data->slug))); ?></h2>
        <?php echo CHtml::image($data->createUser->getAvatar(24), CHtml::encode($data->createUser->nick_name));?> <?php echo CHtml::link(CHtml::encode($data->createUser->nick_name), array('/user/people/userInfo', 'username' =>CHtml::encode( $data->createUser->nick_name))); ?> </span>
        <span class="fa fa-calendar"> <?php echo Yii::app()->getDateFormatter()->formatDateTime($data->create_date, "long", false); ?> </span>
        <span class="fa fa-pencil"> <?php echo CHtml::link(CHtml::encode($data->postsCount), array('/blog/post/blog/', 'slug' => CHtml::encode($data->slug))); ?> </span>
        <span class="fa fa-user"> <?php echo CHtml::link(CHtml::encode($data->membersCount), array('/blog/blog/members','slug' => CHtml::encode($data->slug)));?> </span>
        <span class="fa fa-book"> <?php echo CHtml::encode($data->description); ?> </span>
    </div>
</div>
<hr>
