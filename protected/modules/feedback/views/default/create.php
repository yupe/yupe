<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('feedback')->getCategory() => array(),
        Yii::t('FeedbackModule.feedback', 'Сообщения  ') => array('/feedback/default/index'),
        Yii::t('FeedbackModule.feedback', 'Добавление'),
    );

    $this->pageTitle = Yii::t('FeedbackModule.feedback', 'Сообщения   - добавление');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('FeedbackModule.feedback', 'Управление сообщениями  '), 'url' => array('/feedback/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('FeedbackModule.feedback', 'Добавить сообщение  '), 'url' => array('/feedback/default/create')),
    );
?>
<h1>
    <?php echo Yii::t('FeedbackModule.feedback', 'Сообщения  '); ?>
    <small><?php echo Yii::t('FeedbackModule.feedback', 'добавление'); ?></small>
</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>