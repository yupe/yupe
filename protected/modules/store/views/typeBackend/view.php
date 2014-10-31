<?php
$this->breadcrumbs = array(
    Yii::t('StoreModule.attribute', 'Типы товаров') => array('index'),
    $model->name,
);

$this->pageTitle = Yii::t('StoreModule.attribute', 'Типы товаров - просмотр');

$this->menu = array(
    array('icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.attribute', 'Управление'), 'url' => array('/store/typeBackend/index')),
    array('icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.attribute', 'Добавить'), 'url' => array('/store/typeBackend/create')),
    array('label' => Yii::t('StoreModule.attribute', 'Category') . ' «' . mb_substr($model->name, 0, 32) . '»'),
    array(
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('StoreModule.attribute', 'Редактировать'),
        'url' => array(
            '/store/typeBackend/update',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('StoreModule.attribute', 'Просмотр'),
        'url' => array(
            '/store/typeBackend/view',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('StoreModule.attribute', 'Удалить'),
        'url' => '#',
        'linkOptions' => array(
            'submit' => array('/store/typeBackend/delete', 'id' => $model->id),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t('StoreModule.attribute', 'Do you really want to remove attribute?'),
            'csrf' => true,
        )
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.attribute', 'Просмотр типа'); ?><br/>
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
        ),
    )
); ?>
