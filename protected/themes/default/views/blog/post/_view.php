<div class="post">
    <div class="title">
        <?php echo CHtml::link(CHtml::encode($data->title), array('/blog/post/show/', 'slug' => $data->slug)); ?>
    </div>
    <div class="author">
        <?php echo Yii::t('blog', 'Опубликовал'); ?>:
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
        <?php echo Yii::t('blog', 'Теги'); ?>:
        <?php
        if (($tags = $data->getTags()) != array())
        {
            foreach ($tags as &$tag)
            {
                $tag = CHtml::encode($tag);
                echo CHtml::link($tag, array('/posts/', 'tag' => $tag)).' ';
            }
            unset($tag);
        }
        else
            echo Yii::t('blog', 'тегов нет');
        ?>
    </div>
</div>