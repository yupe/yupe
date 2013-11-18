<?php Yii::import('application.modules.blog.BlogModule'); ?>

<div class="blog-description-members without-btns">
	<div class="blog-description-members-list">
	    <span class="pull-left">
	        <?php echo Yii::t('BlogModule.blog', 'Members'); ?>:
	    </span>
	    <div class="member-listing">
	        <?php if (count($model->members) > 0) :?>
	            <?php foreach ($model->members as $member) : ?>
	                <span class="member-listing-user">
	                    <?php echo CHtml::link($member->nick_name, array('/user/people/userInfo/', 'username' => $member->nick_name));?>
	                </span>
	            <?php endforeach;?>
	        <?php else : ?>
	            <p><?php echo Yii::t('BlogModule.blog', 'There is no members'); ?></p>
	        <?php endif; ?>
	    </div>
	    <div class="clear-both"></div>
	</div>

	<div class="blog-description-members-buttons">
	    <a href="javascript:void(0)" class='btn btn-link list-expanding <?php echo (count($model->members) < 3 ? 'btn-disabled' : ''); ?>'>
	        <?php echo Yii::t('BlogModule.blog', 'All'); ?>
	        <span></span>
	    </a>
		
		<!--
			Снизу должна идти кнопка вступить/выйти в/из блог(а),
			по сути ajax-обработчик, который должен обновлять данный
			виджет и выполнять действия по вступлению/выходу из блога
		-->
	    <!-- <a href="javascript:void(0)" class="btn btn-warning">Вступить в блог</a> -->
	</div>
</div>