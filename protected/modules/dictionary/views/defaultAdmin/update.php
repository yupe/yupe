<?php
    $dictionary = Yii::app()->getModule('dictionary');
    $this->breadcrumbs = array(
        $dictionary->getCategory() => array('/yupe/backend/index', 'category' => $dictionary->getCategoryType() ),
        Yii::t('DictionaryModule.dictionary', 'Справочники') => array('/dictionary/defaultAdmin/index'),
        $model->name => array('/dictionary/defaultAdmin/view', 'id' => $model->id),
        Yii::t('DictionaryModule.dictionary', 'Редактирование'),
    );

    $this->pageTitle = Yii::t('DictionaryModule.dictionary', 'Справочники - редактирование');

    $this->menu = array(
        array('label' => Yii::t('DictionaryModule.dictionary', 'Справочники'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('DictionaryModule.dictionary', 'Управление справочниками'), 'url' => array('/dictionary/defaultAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('DictionaryModule.dictionary', 'Добавление справочника'), 'url' => array('/dictionary/defaultAdmin/create')),
            array('label' => Yii::t('DictionaryModule.dictionary', 'Справочник') . ' «' . mb_substr($model->name, 0, 32) . '»'),
            array('icon' => 'pencil', 'label' => Yii::t('DictionaryModule.dictionary', 'Редактирование справочника'), 'url' => array(
                '/dictionary/defaultAdmin/update',
                'id' => $model->id
            )),
            array('icon' => 'eye-open', 'label' => Yii::t('DictionaryModule.dictionary', 'Просмотреть справочник'), 'url' => array(
                '/dictionary/defaultAdmin/view',
                'id' => $model->id
            )),
            array('icon' => 'trash', 'label' => Yii::t('DictionaryModule.dictionary', 'Удалить справочник'), 'url' => '#', 'linkOptions' => array(
                'submit' => array('/dictionary/defaultAdmin/delete', 'id' => $model->id),
                'confirm' => Yii::t('DictionaryModule.dictionary', 'Вы уверены, что хотите удалить справочник?'),
            )),
        )),
        array('label' => Yii::t('DictionaryModule.dictionary', 'Значения'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('DictionaryModule.dictionary', 'Список значений'), 'url' => array('/dictionary/dataAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('DictionaryModule.dictionary', 'Добавить значение'), 'url' => array('/dictionary/dataAdmin/create')),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('DictionaryModule.dictionary', 'Редактирование справочника'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>