<?php $this->pageTitle = Yii::t('BlogModule.blog','Categorys'); ?>

<?php
	$this->breadcrumbs = array(
	    Yii::t('BlogModule.blog', 'Posts') => array('/blog/post/index/'),
	    Yii::t('BlogModule.blog', 'Categorys')
	);
?>

<?php foreach($categorys as $category):?>
   
	<h4><strong><?php echo CHtml::link(CHtml::encode($category['name']), array('/blog/post/category/', 'alias' => CHtml::encode($category['alias']))); ?></strong>
	<?php echo CHtml::encode($category['description']); ?>
	<hr/>

<?php endforeach;?>