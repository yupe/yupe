<?php $this->pageTitle = Yii::t('BlogModule.blog', 'Latest posts'); ?>

<?php $this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Blogs') => array('/blog/blog/index/'),
    Yii::t('BlogModule.blog', 'Latest posts'),
); ?>

<div class="posts">

	<p class="posts-header">
	   <span class="posts-header-text"><?php echo Yii::t('BlogModule.blog','Latest posts'); ?></span>
	</p>
    
    <?php $this->widget(
		'bootstrap.widgets.TbListView', array(
			'id' => 'posts-list',
		    'dataProvider'  => $model->allPosts(),
		    'itemView'      => '_post',
		    'template'      => "{items}\n{pager}",
		    'ajaxUpdate'    => false,		   
		    'htmlOptions'   => array(
		    	'class' => 'posts-list'
		    )
		)
    ); ?>
</div>

