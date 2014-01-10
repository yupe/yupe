<?php $this->pageTitle = Yii::t('BlogModule.blog', 'Posts list with tag "{tag}"', array('{tag}' => $tag)); ?>

<?php $this->breadcrumbs = array(
    Yii::t('BlogModule.blog', 'Blogs') => array('/blog/blog/index/'),
    Yii::t('BlogModule.blog', 'Posts list'),
); ?>

<p><?php echo Yii::t('BlogModule.blog', 'Posts with tag'); ?> <strong><?php echo $tag; ?></strong>...</p>

<?php foreach($posts as $post):?>
    <?php $this->renderPartial('_post', array('data' => $post)); ?>
<?php endforeach;?>