<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('catalog')->getCategory() => array(),
        Yii::t('catalog', 'Товары') => array('/catalog/default/index'),
        Yii::t('catalog', 'Добавление'),
    );

    $this->pageTitle = Yii::t('catalog', 'Товары - добавление');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('catalog', 'Управление товарами'), 'url' => array('/catalog/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('catalog', 'Добавить товар'), 'url' => array('/catalog/default/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('catalog', 'Товары'); ?>
        <small><?php echo Yii::t('catalog', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>