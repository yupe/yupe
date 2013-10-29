<?php $this->pageTitle = Yii::t('BlogModule.blog', 'Post list'); ?>

<?php $this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Blogs') => array('/blog/blog/index/'),
    Yii::t('BlogModule.blog', 'Post list'),
); ?>

<h1><?php echo Yii::t('BlogModule.blog', 'All posts'); ?>:</h1>

<?php $this->widget(
	'bootstrap.widgets.TbListView', array(
	    'dataProvider' => $model->allPosts(),
	    'itemView'     => '_view_all',
	    'template'     => "{items}\n{pager}",
	)
); ?>