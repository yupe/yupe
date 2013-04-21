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
        <h3><?php echo CHtml::link(CHtml::encode($data->name), array('/blog/blog/show/', 'slug' => $data->slug)); ?></h3>

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

        <b><?php echo Yii::t('blog', 'Записей'); ?>:</b> <?php echo $data->postsCount; ?> | 

        <?php if ($data->membersCount > 0) : ?>
            <b><?php echo Yii::t('blog', 'Участников'); ?>:</b> <?php echo $data->membersCount; ?>
         <?php endif; ?>

        <br /><br />

        <?php
        echo Yii::app()->user->isAuthenticated() && $data->createUser->id != Yii::app()->user->id
            ? ($data->userInBlog() === false
                ? CHtml::link(Yii::t('blog', 'Вступить в блог'), array('/blog/blog/join/', 'blogId' => $data->id))
                : CHtml::link(Yii::t('blog', 'Покинуть в блог'), array('/blog/blog/unjoin/', 'blogId' => $data->id))
            )
            : '';
        ?>
    </div>
</div>
