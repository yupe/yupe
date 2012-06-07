<?php $this->pageTitle = Yii::t('feedback', 'Вопросы и ответы'); ?>

<?php
$this->breadcrumbs = array(
    Yii::t('feedback', 'Вопросы и ответы'),
);
?>

<h1><?php echo Yii::t('feedback', 'Вопросы и ответы')?></h1>

<?php $this->widget('zii.widgets.CListView', array(
                                                  'dataProvider' => $dataProvider,
                                                  'itemView' => '_view',
                                             )); ?>
