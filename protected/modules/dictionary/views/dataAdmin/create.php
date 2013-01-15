<?php
    $dictionary = Yii::app()->getModule('dictionary');
    $this->breadcrumbs = array(
        $dictionary->getCategory() => array('/yupe/backend/index', 'category' => $dictionary->getCategoryType() ),
        Yii::t('DictionaryModule.dictionary', 'Справочники') => array('/dictionary/defaultAdmin/index'),
        Yii::t('DictionaryModule.dictionary', 'Значения справочников') => array('/dictionary/dataAdmin/index'),
        Yii::t('DictionaryModule.dictionary', 'Добавление'),
    );

    $this->pageTitle = Yii::t('DictionaryModule.dictionary', 'Значения справочников - добавление');

    $this->menu = array(
        array('label' => Yii::t('DictionaryModule.dictionary', 'Справочники'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('DictionaryModule.dictionary', 'Управление справочниками'), 'url' => array('/dictionary/defaultAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('DictionaryModule.dictionary', 'Добавление справочника'), 'url' => array('/dictionary/defaultAdmin/create')),
        )),
        array('label' => Yii::t('DictionaryModule.dictionary', 'Значения'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('DictionaryModule.dictionary', 'Список значений'), 'url' => array('/dictionary/dataAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('DictionaryModule.dictionary', 'Добавить значение'), 'url' => array('/dictionary/dataAdmin/create')),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('DictionaryModule.dictionary', 'Значения справочников'); ?>
        <small><?php echo Yii::t('DictionaryModule.dictionary', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>