<div class="blog-description-members without-btns">
    <div class="blog-description-members-list">
	    <span class="pull-left">
	        <?= CHtml::link(
                Yii::t('BlogModule.blog', 'Members'),
                ['/blog/blog/members', 'slug' => CHtml::encode($model->slug)]
            ); ?>:
	    </span>

        <div class="member-listing">
            <?php if (count($model->members)) : ?>
                <?php foreach ($model->members as $member) : ?>
                    <span class="member-listing-user">
	                    <?= CHtml::link(
                            CHtml::encode($member->nick_name),
                            ['/user/people/userInfo/', 'username' => CHtml::encode($member->nick_name)]
                        ); ?>
	                </span>
                <?php endforeach; ?>
                ...
            <?php else : ?>
                <p><?= Yii::t('BlogModule.blog', 'There is no members'); ?></p>
            <?php endif; ?>
        </div>
        <div class="clear-both"></div>
    </div>
</div>
