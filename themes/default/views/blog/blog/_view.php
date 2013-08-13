<div class="row">
    <div class="span8">
        <h4><strong><?php echo CHtml::link(CHtml::encode($data->name), array('/blog/blog/show/', 'slug' => $data->slug)); ?></strong></h4>
    </div>
</div>
<div class="row">
    <div class="span2">
        <a href="#" class="thumbnail">
            <?php  echo CHtml::image(!empty($data->imageUrl) ? $data->imageUrl : Yii::app()->theme->baseUrl . '/web/images/blog-icon.png', $data->name, array('width'  => 64,'height' => 64)); ?>
        </a>
    </div>
    <div class="span6">
        <p> <?php echo strip_tags($data->description); ?></p>
    </div>
</div>
<div class="row">
    <div class="span8">
        <p></p>
        <p>
            <?php echo CHtml::image($data->createUser->getAvatar(16),$data->createUser->nick_name);?>  <?php echo CHtml::link($data->createUser->nick_name, array('/user/people/userInfo', 'username' => $data->createUser->nick_name)); ?>
            | <i class="icon-calendar"></i> <?php echo Yii::app()->getDateFormatter()->formatDateTime($data->create_date, "short", "short"); ?>
            | <i class="icon-pencil"></i> <?php echo CHtml::link($data->postsCount, array('/blog/post/blog/', 'slug' => $data->slug));?>
        </p>
    </div>
</div>
<hr>