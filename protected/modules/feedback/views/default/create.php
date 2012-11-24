<?php
$this->breadcrumbs = array(
    $this->module->getCategory() => array('/feedback/default/index'),
    Yii::t('feedback', 'Сообщения с сайта') => array('/feedback/default/index'),
    Yii::t('feedback', 'Добавление сообщения'),
);

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('feedback', 'Управление сообщениями'), 'url' => array('/feedback/default/index')),
    array('icon' => 'plus-sign white', 'label' => Yii::t('feedback', 'Добавить сообщение'), 'url' => array('/feedback/default/create')),
);
?>

<h1>
    <?php echo Yii::t('feedback', 'Сообщения с сайта'); ?>
    <small><?php echo Yii::t('feedback', 'добавление'); ?></small>
</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>