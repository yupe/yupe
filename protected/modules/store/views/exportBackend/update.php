<?php
/* @var $model Export */

$this->breadcrumbs = array(
    Yii::t('StoreModule.store', 'Экспорт товаров') => array('/store/exportBackend/index'),
    $model->name => array('/store/exportBackend/view', 'id' => $model->id),
    Yii::t('StoreModule.store', 'Редактировать'),
);

$this->pageTitle = Yii::t('StoreModule.store', 'Выгрузка товаров - редактировать');

$this->menu = array(
    array('icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.store', 'Управление'), 'url' => array('/store/exportBackend/index')),
    array('icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.store', 'Добавить'), 'url' => array('/store/exportBackend/create')),
    array('label' => Yii::t('StoreModule.store', 'Выгрузка товаров') . ' «' . mb_substr($model->name, 0, 32) . '»'),
    array(
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('StoreModule.store', 'Редактировать'),
        'url' => array(
            '/store/exportBackend/update',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('StoreModule.store', 'Просмотр'),
        'url' => array(
            '/store/exportBackend/view',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('StoreModule.store', 'Удалить'),
        'url' => '#',
        'linkOptions' => array(
            'submit' => array('/store/exportBackend/delete', 'id' => $model->id),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t('StoreModule.store', 'Удалить эту выгрузку товаров?'),
            'csrf' => true,
        )
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.store', 'Редактировать'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
