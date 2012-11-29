<?php
    $this->breadcrumbs = array(
        $this->getModule('dictionary')->getCategory() => array(''),
        Yii::t('dictionary', 'Справочники') => array('/dictionary/default/index'),
        Yii::t('dictionary', 'Редактирование'),
    );

    $this->pageTitle = Yii::t('dictionary', 'Справочники - редактирование');

    $this->menu = array(
        array('label' => Yii::t('dictionary', 'Справочники'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('dictionary', 'Управление справочниками'), 'url' => array('/dictionary/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('dictionary', 'Добавление справочника'), 'url' => array('/dictionary/default/create')),
            array('label' => Yii::t('dictionary', 'Справочник') . ' «' . mb_substr($model->name, 0, 32) . '»'),
            array('icon' => 'pencil', 'label' => Yii::t('dictionary', 'Редактирование справочника'), 'url' => array(
                '/dictionary/default/update',
                'id' => $model->id
            )),
            array('icon' => 'eye-open', 'label' => Yii::t('dictionary', 'Просмотреть справочник'), 'url' => array(
                '/dictionary/default/view',
                'id' => $model->id
            )),
            array('icon' => 'trash', 'label' => Yii::t('dictionary', 'Удалить справочник'), 'url' => '#', 'linkOptions' => array(
                'submit' => array('/dictionary/default/delete', 'id' => $model->id),
                'confirm' => Yii::t('dictionary', 'Вы уверены, что хотите удалить справочник?'),
            )),
        )),
        array('label' => Yii::t('dictionary', 'Значения'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('dictionary', 'Список значений'), 'url' => array('/dictionary/dictionaryData/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('dictionary', 'Добавить значение'), 'url' => array('/dictionary/dictionaryData/create')),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('dictionary', 'Редактирование справочника'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>