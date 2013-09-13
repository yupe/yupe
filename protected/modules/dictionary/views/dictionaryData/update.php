<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('dictionary')->getCategory() => array(''),
        Yii::t('DictionaryModule.dictionary', 'Dictionaries') => array('/dictionary/default/index'),
        Yii::t('DictionaryModule.dictionary', 'Dictionary items') => array('/dictionary/dictionaryData/index'),
        $model->name => array('/dictionary/dictionaryData/view', 'id' => $model->id),
        Yii::t('DictionaryModule.dictionary', 'Edit'),
    );

    $this->pageTitle = Yii::t('DictionaryModule.dictionary', 'Dictionary items - edit');

    $this->menu = array(
        array('label' => Yii::t('DictionaryModule.dictionary', 'Dictionaries'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('DictionaryModule.dictionary', 'Dictionaries management'), 'url' => array('/dictionary/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('DictionaryModule.dictionary', 'Dictionary crate'), 'url' => array('/dictionary/default/create')),
        )),
        array('label' => Yii::t('DictionaryModule.dictionary', 'Items'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('DictionaryModule.dictionary', 'Items list'), 'url' => array('/dictionary/dictionaryData/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('DictionaryModule.dictionary', 'Create item'), 'url' => array('/dictionary/dictionaryData/create')),
            array('label' => Yii::t('DictionaryModule.dictionary', 'Dictionary item') . ' «' . mb_substr($model->name, 0, 32) . '»'),
            array('icon' => 'pencil', 'label' => Yii::t('DictionaryModule.dictionary', 'Edit dictionary item'), 'url' => array(
                '/dictionary/dictionaryData/update',
                'id' => $model->id
            )),
            array('icon' => 'eye-open', 'label' => Yii::t('DictionaryModule.dictionary', 'Show dictionary item'), 'url' => array(
                '/dictionary/dictionaryData/view',
                'id' => $model->id
            )),
            array('icon' => 'trash', 'label' => Yii::t('DictionaryModule.dictionary', 'Remove dictionary item'), 'url' => '#', 'linkOptions' => array(
                'submit' => array('/dictionary/dictionaryData/delete', 'id' => $model->id),
                'confirm' => Yii::t('DictionaryModule.dictionary', 'Do you really want do delete dictionary item?'),
            )),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('DictionaryModule.dictionary', 'Edit dictionary items'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>