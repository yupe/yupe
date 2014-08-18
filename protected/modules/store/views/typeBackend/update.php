<?php
$this->breadcrumbs = array(
    Yii::t('StoreModule.type', 'Типы товаров') => array('/store/typeBackend/index'),
    $model->name => array('/store/typeBackend/view', 'id' => $model->id),
    Yii::t('StoreModule.type', 'Редактировать'),
);

$this->pageTitle = Yii::t('StoreModule.type', 'Типы товаров - редактировать');

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('StoreModule.type', 'Управление'), 'url' => array('/store/typeBackend/index')),
    array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('StoreModule.type', 'Добавить'), 'url' => array('/store/typeBackend/create')),
    array('label' => Yii::t('StoreModule.type', 'Тип товара') . ' «' . mb_substr($model->name, 0, 32) . '»'),
    array(
        'icon' => 'glyphicon glyphicon-pencil',
        'label' => Yii::t('StoreModule.type', 'Редактировать'),
        'url' => array(
            '/store/typeBackend/update',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'glyphicon glyphicon-eye-open',
        'label' => Yii::t('StoreModule.type', 'Просмотр'),
        'url' => array(
            '/store/typeBackend/view',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'glyphicon glyphicon-trash',
        'label' => Yii::t('StoreModule.type', 'Удалить'),
        'url' => '#',
        'linkOptions' => array(
            'submit' => array('/store/typeBackend/delete', 'id' => $model->id),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t('StoreModule.type', 'Удалить этот тип товара?'),
            'csrf' => true,
        )
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.type', 'Редактировать'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model, 'availableAttributes' => $availableAttributes)); ?>
