<div class="row-fluid">

    <div class="span3">
        <?php echo CHtml::image($data->getImageUrl(), $data->name, array('width' => 64, 'height' => 64, 'class' => 'thumbnail')); ?>
    </div>

    <div class="span6">
        <i class="icon-pencil"></i> <?php echo CHtml::link(CHtml::encode($data->name), array('/blog/blog/show/', 'slug' => $data->slug)); ?><br/>
        <i class="icon-user"></i> <?php echo CHtml::image($data->createUser->getAvatar(16), $data->createUser->nick_name); ?>  <?php echo CHtml::link($data->createUser->nick_name, array('/user/people/userInfo', 'username' => $data->createUser->nick_name)); ?> <br/>
        <i class="icon-calendar"></i> <?php echo Yii::app()->getDateFormatter()->formatDateTime($data->create_date, "short", "short"); ?> </br>
        <i class="icon-pencil"></i> <?php echo CHtml::link($data->postsCount, array('/blog/post/blog/', 'slug' => $data->slug)); ?> </br>
        <i class="icon-note"> <?php echo strip_tags($data->description); ?>
    </div>
</div>
<hr>