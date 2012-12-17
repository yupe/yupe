<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('feedback')->getCategory() => array(),
        Yii::t('feedback', 'Сообщения с сайта') => array('/feedback/default/index'),
        Yii::t('feedback', 'Добавление'),
    );

    $this->pageTitle = Yii::t('feedback', 'Сообщения с сайта - добавление');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('feedback', 'Управление сообщениями с сайта'), 'url' => array('/feedback/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('feedback', 'Добавить сообщение с сайта'), 'url' => array('/feedback/default/create')),
    );
?>
<h1>
    <?php echo Yii::t('feedback', 'Сообщения с сайта'); ?>
    <small><?php echo Yii::t('feedback', 'добавление'); ?></small>
</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>