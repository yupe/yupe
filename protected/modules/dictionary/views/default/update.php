<?php
    $this->breadcrumbs = array(
        $this->getModule('dictionary')->getCategory() => array(''),
        Yii::t('DictionaryModule.dictionary', 'Справочники') => array('/dictionary/default/index'),
        $model->name => array('/dictionary/default/view', 'id' => $model->id),
        Yii::t('DictionaryModule.dictionary', 'Редактирование'),
    );

    $this->pageTitle = Yii::t('DictionaryModule.dictionary', 'Справочники - редактирование');

    $this->menu = array(
        array('label' => Yii::t('DictionaryModule.dictionary', 'Справочники'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('DictionaryModule.dictionary', 'Управление справочниками'), 'url' => array('/dictionary/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('DictionaryModule.dictionary', 'Добавление справочника'), 'url' => array('/dictionary/default/create')),
            array('label' => Yii::t('DictionaryModule.dictionary', 'Справочник') . ' «' . mb_substr($model->name, 0, 32) . '»'),
            array('icon' => 'pencil', 'label' => Yii::t('DictionaryModule.dictionary', 'Редактирование справочника'), 'url' => array(
                '/dictionary/default/update',
                'id' => $model->id
            )),
            array('icon' => 'eye-open', 'label' => Yii::t('DictionaryModule.dictionary', 'Просмотреть справочник'), 'url' => array(
                '/dictionary/default/view',
                'id' => $model->id
            )),
            array('icon' => 'trash', 'label' => Yii::t('DictionaryModule.dictionary', 'Удалить справочник'), 'url' => '#', 'linkOptions' => array(
                'submit' => array('/dictionary/default/delete', 'id' => $model->id),
                'params' => array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken),
                'confirm' => Yii::t('DictionaryModule.dictionary', 'Вы уверены, что хотите удалить справочник?'),
            )),
        )),
        array('label' => Yii::t('DictionaryModule.dictionary', 'Значения'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('DictionaryModule.dictionary', 'Список значений'), 'url' => array('/dictionary/dictionaryData/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('DictionaryModule.dictionary', 'Добавить значение'), 'url' => array('/dictionary/dictionaryData/create')),
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
