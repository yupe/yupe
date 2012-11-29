<?php
    $this->breadcrumbs = array(
        $this->getModule('dictionary')->getCategory() => array(''),
        Yii::t('dictionary', 'Справочники') => array('/dictionary/default/index'),
        Yii::t('dictionary', 'Значения справочников') => array('/dictionary/dictionaryData/index'),
        Yii::t('dictionary', 'Просмотр'),
    );

    $this->pageTitle = Yii::t('dictionary', 'Значения справочников - просмотр');

    $this->menu = array(
        array('label' => Yii::t('dictionary', 'Справочники'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('dictionary', 'Управление справочниками'), 'url' => array('/dictionary/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('dictionary', 'Добавление справочника'), 'url' => array('/dictionary/default/create')),
        )),
        array('label' => Yii::t('dictionary', 'Значения'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('dictionary', 'Список значений'), 'url' => array('/dictionary/dictionaryData/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('dictionary', 'Добавить значение'), 'url' => array('/dictionary/dictionaryData/create')),
            array('label' => Yii::t('dictionary', 'Значение справочника') . ' «' . mb_substr($model->name, 0, 32) . '»'),
            array('icon' => 'pencil', 'label' => Yii::t('dictionary', 'Редактирование значение справочника'), 'url' => array(
                '/dictionary/dictionaryData/update',
                'id' => $model->id
            )),
            array('icon' => 'eye-open', 'label' => Yii::t('dictionary', 'Просмотреть значение справочника'), 'url' => array(
                '/dictionary/dictionaryData/view',
                'id' => $model->id
            )),
            array('icon' => 'trash', 'label' => Yii::t('dictionary', 'Удалить значение справочника'), 'url' => '#', 'linkOptions' => array(
                'submit' => array('/dictionary/dictionaryData/delete', 'id' => $model->id),
                'confirm' => Yii::t('dictionary', 'Вы уверены, что хотите удалить значение справочника?'),
            )),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('dictionary', 'Просмотр значения справочника'); ?><br />
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