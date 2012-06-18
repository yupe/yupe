<?php $this->pageTitle = $news->title; ?>

<?php
$this->breadcrumbs = array(
    'Новости' => array('/news/news/list/'),
    CHtml::encode($news->title)
);
?>

<?php $this->renderPartial('_view', array(
                                         'data' => $news,
                                    )); ?>