<?php
    $this->pageTitle = Yii::t('BlogModule.blog','Posts of "{category}" category', array('{category}' => CHtml::encode($target->name)));
    $this->description = Yii::t('BlogModule.blog','Posts of "{category}" category', array('{category}' => CHtml::encode($target->name)));
    $this->keywords = $target->name;
?>

<?php
	$this->breadcrumbs = array(
	    Yii::t('BlogModule.blog', 'Posts') => array('/blog/post/index/'),
	    Yii::t('BlogModule.blog', 'Categorys') => array('/blog/post/categorys/'),   
	    CHtml::encode($target->name),
	);
?>

<p><?php echo Yii::t('BlogModule.blog','Posts of "{category}" category', array('{category}' => CHtml::encode($target->name)));?></p>

<?php $this->widget('bootstrap.widgets.TbListView', array(
        'dataProvider' => $posts->search(),
        'itemView'     => '_view',
        'template'     => "{items}\n{pager}",
)); ?>