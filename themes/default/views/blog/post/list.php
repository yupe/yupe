<?php $this->pageTitle = Yii::t('blog', 'Список записей'); ?>

<?php $this->breadcrumbs = array(
    Yii::t('blog', 'Блоги') => array('/blog/blog/index/'),
    Yii::t('blog', 'список записей'),
); ?>

<p><?php echo Yii::t('blog', 'Записи с меткой'); ?> <strong><?php echo $tag; ?></strong>...</p>

<?php foreach($posts as $post):?>
    <?php $this->renderPartial('_view', array('data' => $post)); ?>
<?php endforeach;?>