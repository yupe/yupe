<div class="post">
    <h4><?php echo CHtml::link(CHtml::encode($data->title), array('/blog/post/show/', 'slug' => $data->slug)); ?></h4>
    <div class="alert alert-info">
        <?php echo Yii::t('blog', 'опубликовал'); ?>:
        <b><?php echo CHtml::link($data->createUser->nick_name, array('/user/people/userInfo', 'username' => $data->createUser->nick_name)); ?></b>

        <?php echo Yii::t('blog', 'в блоге'); ?>:
        "<?php echo CHtml::link($data->blog->name, array('/blog/blog/show/', 'slug' => $data->blog->slug)); ?>"

        <?php echo Yii::t('blog', 'дата'); ?>:
        <?php echo Yii::app()->getDateFormatter()->formatDateTime($data->publish_date, "short", "short"); ?>
    </div>
    <div class="content">
        <p><?php echo $data->quote; ?></p>
    </div>
    <div class="nav">
        <?php echo Yii::t('blog', 'теги'); ?>:
        <?php if (($tags = $data->getTags()) != array()):?>
            <?php foreach ($tags as $tag):?>
                <?php $tag = CHtml::encode($tag);?>
                <span class="label label-info">
                    <?php echo CHtml::link($tag, array('/posts/', 'tag' => $tag)).' '?>
                </span>
            <?php endforeach?>
        <?php endif;?>
    </div>
</div>