<?php
$this->breadcrumbs = array(
    Yii::t('StoreModule.attribute', 'Атрибуты') => array('index'),
    $model->name,
);

$this->pageTitle = Yii::t('StoreModule.attribute', 'Атрибуты - просмотр');

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('StoreModule.attribute', 'Управление'), 'url' => array('/store/attributeBackend/index')),
    array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('StoreModule.attribute', 'Добавить'), 'url' => array('/store/attributeBackend/create')),
    array('label' => Yii::t('StoreModule.attribute', 'Category') . ' «' . mb_substr($model->name, 0, 32) . '»'),
    array(
        'icon' => 'glyphicon glyphicon-pencil',
        'label' => Yii::t('StoreModule.attribute', 'Редактировать'),
        'url' => array(
            '/store/attributeBackend/update',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'glyphicon glyphicon-eye-open',
        'label' => Yii::t('StoreModule.attribute', 'Просмотр'),
        'url' => array(
            '/store/attributeBackend/view',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'glyphicon glyphicon-trash',
        'label' => Yii::t('StoreModule.attribute', 'Удалить'),
        'url' => '#',
        'linkOptions' => array(
            'submit' => array('/store/attributeBackend/delete', 'id' => $model->id),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t('StoreModule.attribute', 'Do you really want to remove attribute?'),
            'csrf' => true,
        )
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.attribute', 'Просмотр атрибута'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    array(
        'data' => $model,
        'attributes' => array(
            'id',
            'name',
            'title',
            array(
                'name' => 'type',
                'type' => 'text',
                'value' => $model->getTypeTitle($model->type),
            ),
            array(
                'name' => 'required',
                'value' => $model->required ? Yii::t("StoreModule.attribute", 'Да') : Yii::t("StoreModule.attribute", 'Нет'),
            ),
        ),
    )
); ?>
