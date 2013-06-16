<?php
/**
 * Отображение для blog/_view:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
 ?>

<div class="view">
    <div class='blog-icon'>
        <?php
        echo CHtml::image(
            !empty($data->imageUrl)
            ? $data->imageUrl
            : Yii::app()->theme->baseUrl . '/web/images/blog-icon.png', $data->name,
            array(
                'width'  => 64,
                'height' => 64
            )
        ); ?>
    </div>
    <div class='blog-body'>
        <h3><?php echo CHtml::link(CHtml::encode($data->name), array('/blog/blog/show/', 'slug' => $data->slug)); ?> <a href="<?php echo Yii::app()->createUrl('/blog/rss/feed/',array('blog' => $data->id));?>"><img src="<?php echo Yii::app()->theme->baseUrl?>/web/images/rss.png" alt="Подпишитесь на обновление блога '<?php echo $data->name?>'" title="Подпишитесь на обновление блога '<?php echo $data->name?>'"></a></h3>

        <b><?php echo CHtml::encode($data->getAttributeLabel('create_date')); ?>:</b>
        <?php
        echo CHtml::link(
            CHtml::encode(
                $data->createUser->getFullName()
            ), array(
                '/user/people/userInfo/',
                'username' => $data->createUser->nick_name,
            )
        ); ?>
        <?php echo Yii::app()->getDateFormatter()->formatDateTime($data->create_date, "short", "short"); ?>
        <br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
        <?php echo $data->description; ?>

        <span class='blog-stats'>
            <b><?php echo Yii::t('blog', 'Записей'); ?>:</b>
            <?php
            echo $data->postsCount < 1
                ? $data->postsCount
                : CHtml::link($data->postsCount, array('/blog/blog/lastpostsofblog'), array('class' => 'get-posts-list', 'rel' => $data->id))
            ?> | 

            <?php
            echo $data->membersCount > 0
                ? '<b>' . Yii::t('blog', 'Участников') . ':</b> <a href="javascript:void(0);" class="get-members" rel="' . $data->id . '">' . $data->membersCount . '</a>'
                : '';
            ?>
        </span>

        <br /><br />

        <?php
        echo Yii::app()->user->isAuthenticated() && $data->createUser->id != Yii::app()->user->getId()
            ? ($data->userInBlog() === false
                ? CHtml::link(Yii::t('blog', 'Вступить в блог'), array('/blog/blog/join/', 'blogId' => $data->id), array('class' => 'action-blog', 'type' => 'join', 'rel' => $data->id))
                : CHtml::link(Yii::t('blog', 'Покинуть в блог'), array('/blog/blog/unjoin/', 'blogId' => $data->id), array('class' => 'action-blog', 'type' => 'unjoin', 'rel' => $data->id))
            )
            : '';
        ?>
    </div>
</div>