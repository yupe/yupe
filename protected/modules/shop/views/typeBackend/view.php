<?php
$this->breadcrumbs = array(
    Yii::t('ShopModule.attribute', 'Типы товаров') => array('index'),
    $model->name,
);

$this->pageTitle = Yii::t('ShopModule.attribute', 'Типы товаров - просмотр');

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.attribute', 'Управление'), 'url' => array('/shop/typeBackend/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.attribute', 'Добавить'), 'url' => array('/shop/typeBackend/create')),
    array('label' => Yii::t('ShopModule.attribute', 'Category') . ' «' . mb_substr($model->name, 0, 32) . '»'),
    array('icon' => 'pencil', 'label' => Yii::t('ShopModule.attribute', 'Редактировать'), 'url' => array(
        '/shop/typeBackend/update',
        'id' => $model->id
    )),
    array('icon' => 'eye-open', 'label' => Yii::t('ShopModule.attribute', 'Просмотр'), 'url' => array(
        '/shop/typeBackend/view',
        'id' => $model->id
    )),
    array('icon' => 'trash', 'label' => Yii::t('ShopModule.attribute', 'Удалить'), 'url' => '#', 'linkOptions' => array(
        'submit'  => array('/shop/typeBackend/delete', 'id' => $model->id),
        'params'  => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
        'confirm' => Yii::t('ShopModule.attribute', 'Do you really want to remove attribute?'),
        'csrf'    => true,
    )),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ShopModule.attribute', 'Просмотр типа'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data'       => $model,
    'attributes' => array(
        'id',
        'name',
    ),
)); ?>
