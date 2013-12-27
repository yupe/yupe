<div class="row-fluid">
    <div class="span2">
        <?php echo CHtml::image($data->getImageUrl(), $data->name, array('width' => 64, 'height' => 64, 'class' => 'thumbnail')); ?>
    </div>
    <div class="span7 blog-info">
        <h2><?php echo CHtml::link(CHtml::encode($data->name), array('/blog/blog/show/', 'slug' => $data->slug)); ?></h2>
        <?php echo CHtml::image($data->createUser->getAvatar(24), $data->createUser->nick_name);?> <?php echo CHtml::link($data->createUser->nick_name, array('/user/people/userInfo', 'username' => $data->createUser->nick_name)); ?> </span>
        <span class="icon-calendar"> <?php echo Yii::app()->getDateFormatter()->formatDateTime($data->create_date, "long", false); ?> </span>
        <span class="icon-pencil"> <?php echo CHtml::link($data->postsCount, array('/blog/post/blog/', 'slug' => $data->slug)); ?> </span>
        <span class="icon-user"> <?php echo $data->membersCount;?> </span>
        <span class="icon-book"> <?php echo strip_tags($data->description); ?> </span>
    </div>
</div>
<hr>
