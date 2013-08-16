<?php foreach($models as $data):?>
    <div class="row">
        <div class="span6">
            <h4><strong><?php echo CHtml::link(CHtml::encode($data->title), array('/blog/post/show/', 'slug' => $data->slug)); ?></strong></h4>
        </div>
    </div>
    <div class="row">
        <div class="span6">
            <p> <?php echo $data->getQuote(); ?></p>
            <!--<p><?php echo CHtml::link(Yii::t('default','читать...'), array('/blog/post/show/', 'slug' => $data->slug),array('class' => 'btn'));?></p>-->
        </div>
    </div>
    <div class="row">
        <div class="span6">
            <p></p>
            <p>
                <?php echo CHtml::image($data->createUser->getAvatar(16),$data->createUser->nick_name);?> <?php echo CHtml::link($data->createUser->nick_name, array('/user/people/userInfo', 'username' => $data->createUser->nick_name)); ?>
                | <i class="icon-pencil"></i> <?php echo CHtml::link($data->blog->name, array('/blog/blog/show/', 'slug' => $data->blog->slug)); ?>
                | <i class="icon-calendar"></i> <?php echo Yii::app()->getDateFormatter()->formatDateTime($data->publish_date, "short", "short"); ?>
                | <i class="icon-comment"></i>  <?php echo CHtml::link($data->commentsCount, array('/blog/post/show/', 'slug' => $data->slug, '#' => 'comments'));?>
                | <i class="icon-tags"></i>
                <?php if (($tags = $data->getTags()) != array()):?>
                    <?php foreach ($tags as $tag):?>
                        <?php $tag = CHtml::encode($tag);?>
                        <span class="label label-info">
                        <?php echo CHtml::link($tag, array('/posts/', 'tag' => $tag)).' '?>
                    </span>
                    <?php endforeach?>
                <?php endif;?>
            </p>
        </div>
    </div>
    <hr>
<?php endforeach?>