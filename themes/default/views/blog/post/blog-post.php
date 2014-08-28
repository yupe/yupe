<?php
$this->pageTitle = Yii::t('BlogModule.blog', 'Posts of "{blog}" blog', array('{blog}' => CHtml::encode($target->name)));
$this->description = Yii::t(
    'BlogModule.blog',
    'Posts of "{blog}" blog',
    array('{blog}' => CHtml::encode($target->name))
);
$this->keywords = $target->name;
?>

<?php
$this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Blogs') => array('/blog/blog/index/'),
    CHtml::encode($target->name)       => array('/blog/blog/show/', 'slug' => CHtml::encode($target->slug)),
    Yii::t('BlogModule.blog', 'Records'),
);
?>

<p><?php echo Yii::t(
        'BlogModule.blog',
        'Posts of "{blog}" blog',
        array('{blog}' => CHtml::encode($target->name))
    ); ?></p>

<?php $this->widget(
    'bootstrap.widgets.TbListView',
    array(
        'dataProvider' => $posts->search(),
        'itemView'     => '_post',
        'template'     => "{items}\n{pager}",
    )
); ?>
