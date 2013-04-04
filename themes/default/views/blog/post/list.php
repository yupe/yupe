<?php $this->pageTitle = Yii::t('blog', 'Список записей'); ?>

<?php $this->breadcrumbs = array(
    Yii::t('blog', 'Блоги') => array('/blog/blog/index/'),
    Yii::t('blog', 'список записей'),
); ?>

<p><?php echo Yii::t('blog', 'Записи с меткой'); ?> <b><?php echo $tag; ?></b>...</p>

<?php
foreach($posts as $post)
    $this->renderPartial('_view', array('data' => $post));
?>