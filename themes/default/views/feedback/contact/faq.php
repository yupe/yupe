<?php $this->pageTitle = Yii::t('feedback', 'Вопросы и ответы'); ?>

<?php
$this->breadcrumbs = array(
    Yii::t('feedback', 'Вопросы и ответы'),
);
?>

<h1><?php echo Yii::t('feedback', 'Вопросы и ответы')?></h1>

<?php echo CHtml::link('ЗАДАЙТЕ ВОПРОС',array('/feedback/contact/'));?>

<?php $this->widget('zii.widgets.CListView', array(
                                                  'dataProvider' => $dataProvider,
                                                  'itemView' => '_view',
                                             )); ?>

<?php echo CHtml::link('ЗАДАЙТЕ ВОПРОС',array('/feedback/contact/'));?> <br/><br/>


<div style='float:left;padding-right:5px'>
    <?php $this->widget('application.modules.social.widgets.ysc.yandex.YandexShareApi', array(
    'type' => 'button',
    'services' => 'all'
));?>
</div>
