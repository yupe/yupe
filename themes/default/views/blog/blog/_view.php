<div class="row">
    <div class="col-sm-2">
        <?php echo CHtml::image(
            $data->getImageUrl(),
            CHtml::encode($data->name),
            array('width' => 64, 'height' => 64, 'class' => 'thumbnail')
        ); ?>
    </div>
    <div class="col-sm-6 blog-info">

        <h2><?php echo CHtml::link(
                CHtml::encode($data->name),
                array('/blog/blog/show/', 'slug' => CHtml::encode($data->slug))
            ); ?></h2>
        <?php echo CHtml::image(
            $data->createUser->getAvatar(24),
            CHtml::encode($data->createUser->nick_name)
        ); ?> <?php echo CHtml::link(
            CHtml::encode($data->createUser->nick_name),
            array('/user/people/userInfo', 'username' => CHtml::encode($data->createUser->nick_name))
        ); ?> </span>
        <span> <i class="glyphicon glyphicon-calendar"></i> <?php echo Yii::app()->getDateFormatter()->formatDateTime(
                $data->create_date,
                "long",
                false
            ); ?> </span>
        <span> <i class="glyphicon glyphicon-pencil"></i> <?php echo CHtml::link(
                CHtml::encode($data->postsCount),
                array('/blog/post/blog/', 'slug' => CHtml::encode($data->slug))
            ); ?> </span>
        <span> <i class="glyphicon glyphicon-user"></i> <?php echo CHtml::link(
                CHtml::encode($data->membersCount),
                array('/blog/blog/members', 'slug' => CHtml::encode($data->slug))
            ); ?> </span>
        <span> <?php echo strip_tags($data->description); ?> </span>
    </div>

    <div class="col-sm-4 text-right">
        <?php $this->widget(
            'application.modules.blog.widgets.JoinBlogWidget',
            array('user' => Yii::app()->user, 'blog' => $data)
        ); ?>
        <?php
        if ($data->userIn(Yii::app()->user->getId())) {
            echo CHtml::link(Yii::t('BlogModule.blog', 'Add a post'), ['/blog/publisher/write', 'blog-id' => $data->id], ['class' => 'btn btn-success btn-sm']);
        }
        ?>
    </div>
</div>
<hr/>
