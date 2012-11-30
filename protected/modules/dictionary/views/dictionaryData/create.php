<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('dictionary')->getCategory() => array(),
        Yii::t('dictionary', 'Справочники') => array('/dictionary/default/index'),
        Yii::t('dictionary', 'Значения справочников') => array('/dictionary/dictionaryData/index'),
        Yii::t('dictionary', 'Добавление'),
    );

    $this->pageTitle = Yii::t('dictionary', 'Значения справочников - добавление');

    $this->menu = array(
        array('label' => Yii::t('dictionary', 'Справочники'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('dictionary', 'Управление справочниками'), 'url' => array('/dictionary/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('dictionary', 'Добавление справочника'), 'url' => array('/dictionary/default/create')),
        )),
        array('label' => Yii::t('dictionary', 'Значения'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('dictionary', 'Список значений'), 'url' => array('/dictionary/dictionaryData/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('dictionary', 'Добавить значение'), 'url' => array('/dictionary/dictionaryData/create')),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('dictionary', 'Значения справочников'); ?>
        <small><?php echo Yii::t('dictionary', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>