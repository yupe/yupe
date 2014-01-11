<?php $this->pageTitle = Yii::t('BlogModule.blog', 'Post list'); ?>

<?php $this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Blogs') => array('/blog/blog/index/'),
    Yii::t('BlogModule.blog', 'Post list'),
); ?>

<?php $this->widget(
	'bootstrap.widgets.TbListView', array(
	    'dataProvider' => $model->allPosts(),
	    'itemView'     => '_view_all',
	    'template'     => "{items}\n{pager}",
	    'ajaxUpdate'   => false
	)
); ?>