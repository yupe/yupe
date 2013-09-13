<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('dictionary')->getCategory() => array(),
        Yii::t('DictionaryModule.dictionary', 'Dictionaries') => array('/dictionary/default/index'),
        Yii::t('DictionaryModule.dictionary', 'Create'),
    );

    $this->pageTitle = Yii::t('DictionaryModule.dictionary', 'Dictionaries - create');

    $this->menu = array(
        array('label' => Yii::t('DictionaryModule.dictionary', 'Dictionaries'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('DictionaryModule.dictionary', 'Dictionaries management'), 'url' => array('/dictionary/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('DictionaryModule.dictionary', 'Dictionary crate'), 'url' => array('/dictionary/default/create')),
        )),
        array('label' => Yii::t('DictionaryModule.dictionary', 'Items'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('DictionaryModule.dictionary', 'Items list'), 'url' => array('/dictionary/dictionaryData/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('DictionaryModule.dictionary', 'Create item'), 'url' => array('/dictionary/dictionaryData/create')),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('DictionaryModule.dictionary', 'Dictionaries'); ?>
        <small><?php echo Yii::t('DictionaryModule.dictionary', 'create'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>