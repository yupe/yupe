<?php $this->pageTitle = Yii::t('BlogModule.blog','Posts of "{category}" category', array('{category}' => $target->name)); ?>

<?php
	$this->breadcrumbs = array(
	    Yii::t('BlogModule.blog', 'Posts') => array('/blog/post/index/'),
	    Yii::t('BlogModule.blog', 'Categorys') => array('/blog/post/categorys/'),   
	    $target->name,
	);
?>

<p><?php echo Yii::t('BlogModule.blog','Posts of "{category}" category', array('{category}' => $target->name));?></p>

<?php $this->widget('bootstrap.widgets.TbListView', array(
        'dataProvider' => $posts->search(),
        'itemView'     => '_view',
        'template'     => "{items}\n{pager}",
)); ?>