<div class="posts-list-block-tags">
    <div>
        <span class="posts-list-block-tags-block">
            <i class="glyphicon glyphicon-tags"></i>

            <?= Yii::t('BlogModule.blog', 'Tags'); ?>:

            <?php foreach ((array)$post->getTags() as $tag): ?>
                <span>
                    <?= CHtml::link(CHtml::encode($tag), ['/posts/', 'tag' => CHtml::encode($tag)]); ?>
                </span>
            <?php endforeach; ?>
        </span>

        <span>
            <i class="glyphicon glyphicon-user"></i>
            <?php $this->widget(
                'application.modules.user.widgets.UserPopupInfoWidget',
                [
                    'model' => $post->createUser
                ]
            ); ?>
        </span>

        <span class="posts-list-block-tags-comments">
            <i class="glyphicon glyphicon-comment"></i>

            <?= CHtml::link(
                $post->getCommentCount(),
                $post->getUrl(['#' => 'comments'])
            ); ?>
        </span>
    </div>
</div>
