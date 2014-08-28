<div class="blog-description-members without-btns">
    <div class="blog-description-members-list">
	    <span class="pull-left">
	        <?php echo CHtml::link(
                Yii::t('BlogModule.blog', 'Members'),
                array('/blog/blog/members', 'slug' => CHtml::encode($model->slug))
            ); ?>:
	    </span>

        <div class="member-listing">
            <?php if (count($model->members)) : ?>
                <?php foreach ($model->members as $member) : ?>
                    <span class="member-listing-user">
	                    <?php echo CHtml::link(
                            CHtml::encode($member->nick_name),
                            array('/user/people/userInfo/', 'username' => CHtml::encode($member->nick_name))
                        ); ?>
	                </span>
                <?php endforeach; ?>
                ...
            <?php else : ?>
                <p><?php echo Yii::t('BlogModule.blog', 'There is no members'); ?></p>
            <?php endif; ?>
        </div>
        <div class="clear-both"></div>
    </div>
</div>
