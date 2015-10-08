<div class="row">
    <div class="col-sm-2">
        <?= CHtml::image(
            $data->getImageUrl(64, 64),
            CHtml::encode($data->name),
            ['width' => 64, 'height' => 64, 'class' => 'thumbnail']
        ); ?>
    </div>
    <div class="col-sm-6 blog-info">

        <h2><?= CHtml::link(
                CHtml::encode($data->name),
                ['/blog/blog/view/', 'slug' => CHtml::encode($data->slug)]
            ); ?></h2>
        <?= CHtml::image(
            $data->createUser->getAvatar(24),
            CHtml::encode($data->createUser->nick_name)
        ); ?> <?= CHtml::link(
            CHtml::encode($data->createUser->nick_name),
            ['/user/people/userInfo', 'username' => CHtml::encode($data->createUser->nick_name)]
        ); ?> </span>
        <span> <i class="glyphicon glyphicon-calendar"></i> <?= Yii::app()->getDateFormatter()->formatDateTime(
                $data->create_time,
                "long",
                false
            ); ?> </span>
        <span> <i class="glyphicon glyphicon-pencil"></i> <?= CHtml::link(
                CHtml::encode($data->postsCount),
                ['/blog/post/blog/', 'slug' => CHtml::encode($data->slug)]
            ); ?> </span>
        <span> <i class="glyphicon glyphicon-user"></i> <?= CHtml::link(
                CHtml::encode($data->membersCount),
                ['/blog/blog/members', 'slug' => CHtml::encode($data->slug)]
            ); ?> </span>
        <span> <?= strip_tags($data->description); ?> </span>
    </div>

    <div class="col-sm-4 text-right">
        <?php $this->widget(
            'application.modules.blog.widgets.JoinBlogWidget',
            ['user' => Yii::app()->getUser(), 'blog' => $data]
        ); ?>
        <?php
        if ($data->userIn(Yii::app()->getUser()->getId())) {
            echo CHtml::link(Yii::t('BlogModule.blog', 'Add a post'), ['/blog/publisher/write', 'blog-id' => $data->id], ['class' => 'btn btn-success btn-sm']);
        }
        ?>
    </div>
</div>
<hr/>
