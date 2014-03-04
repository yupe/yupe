<?php
    $this->breadcrumbs = array(
        Yii::t('ShopModule.producer', 'Производители') => array('/shop/producerBackend/index'),
        Yii::t('ShopModule.producer', 'Добавить'),
    );

    $this->pageTitle = Yii::t('ShopModule.producer', 'Производители - добавить');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.producer', 'Управление производителями'), 'url' => array('/shop/producerBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.producer', 'Добавить производителя'), 'url' => array('/shop/producerBackend/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ShopModule.producer', 'Производители'); ?>
        <small><?php echo Yii::t('ShopModule.producer', 'добавить'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>