<?php
$dictionary = Yii::app()->getModule('dictionary');
    $this->breadcrumbs = array(
        $dictionary->getCategory() => array('/yupe/backend/index', 'category' => $dictionary->getCategoryType() ),
        Yii::t('DictionaryModule.dictionary', 'Справочники') => array('/dictionary/defaultAdmin/index'),
        Yii::t('DictionaryModule.dictionary', 'Значения справочников') => array('/dictionary/dataAdmin/index'),
        $model->name,
    );

    $this->pageTitle = Yii::t('DictionaryModule.dictionary', 'Значения справочников - просмотр');

    $this->menu = array(
        array('label' => Yii::t('DictionaryModule.dictionary', 'Справочники'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('DictionaryModule.dictionary', 'Управление справочниками'), 'url' => array('/dictionary/defaultAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('DictionaryModule.dictionary', 'Добавление справочника'), 'url' => array('/dictionary/defaultAdmin/create')),
        )),
        array('label' => Yii::t('DictionaryModule.dictionary', 'Значения'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('DictionaryModule.dictionary', 'Список значений'), 'url' => array('/dictionary/dataAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('DictionaryModule.dictionary', 'Добавить значение'), 'url' => array('/dictionary/dataAdmin/create')),
            array('label' => Yii::t('DictionaryModule.dictionary', 'Значение справочника') . ' «' . mb_substr($model->name, 0, 32) . '»'),
            array('icon' => 'pencil', 'label' => Yii::t('DictionaryModule.dictionary', 'Редактирование значение справочника'), 'url' => array(
                '/dictionary/dataAdmin/update',
                'id' => $model->id
            )),
            array('icon' => 'eye-open', 'label' => Yii::t('DictionaryModule.dictionary', 'Просмотреть значение справочника'), 'url' => array(
                '/dictionary/dataAdmin/view',
                'id' => $model->id
            )),
            array('icon' => 'trash', 'label' => Yii::t('DictionaryModule.dictionary', 'Удалить значение справочника'), 'url' => '#', 'linkOptions' => array(
                'submit' => array('/dictionary/dataAdmin/delete', 'id' => $model->id),
                'confirm' => Yii::t('DictionaryModule.dictionary', 'Вы уверены, что хотите удалить значение справочника?'),
            )),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('DictionaryModule.dictionary', 'Просмотр значения справочника'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data'       => $model,
    'attributes' => array(
        'id',
        array(
            'name'  => 'group_id',
            'value' => $model->group->name,
        ),
        'code',
        'name',
        'value',
        'description',
        array(
            'name'  => 'creation_date',
            'value' => Yii::app()->getDateFormatter()->formatDateTime($model->creation_date, "short", "short"),
        ),
        array(
            'name'  => 'update_date',
            'value' => Yii::app()->getDateFormatter()->formatDateTime($model->update_date, "short", "short"),
        ),
        array(
            'name'  => 'create_user_id',
            'value' => $model->createUser->getFullName(),
        ),
        array(
            'name'  => 'update_user_id',
            'value' => $model->updateUser->getFullName(),
        ),
        array(
            'name'  => 'status',
            'value' => $model->getStatus(),
        ),
    ),
)); ?>