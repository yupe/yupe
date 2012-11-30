<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('queue')->getCategory() => array(),
        Yii::t('queue', 'Задания') => array('/queue/default/index'),
        Yii::t('queue', 'Добавление'),
    );

    $this->pageTitle = Yii::t('queue', 'Задания - добавление');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('queue', 'Список заданий'), 'url' => array('/queue/default/index')),
        array('icon' => 'plus-sign', 'label' =>  Yii::t('queue', 'Добавление задания'), 'url' => array('/queue/default/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('queue', 'Задания'); ?>
        <small><?php echo Yii::t('queue', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>