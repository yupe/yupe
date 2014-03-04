<?php
$this->breadcrumbs = array(
    Yii::t('ShopModule.type', 'Типы товаров') => array('/shop/typeBackend/index'),
    $model->name                              => array('/shop/typeBackend/view', 'id' => $model->id),
    Yii::t('ShopModule.type', 'Редактировать'),
);

$this->pageTitle = Yii::t('ShopModule.type', 'Типы товаров - редактировать');

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.type', 'Управление'), 'url' => array('/shop/typeBackend/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.type', 'Добавить'), 'url' => array('/shop/typeBackend/create')),
    array('label' => Yii::t('ShopModule.type', 'Тип товара') . ' «' . mb_substr($model->name, 0, 32) . '»'),
    array('icon' => 'pencil', 'label' => Yii::t('ShopModule.type', 'Редактировать'), 'url' => array(
        '/shop/typeBackend/update',
        'id' => $model->id
    )),
    array('icon' => 'eye-open', 'label' => Yii::t('ShopModule.type', 'Просмотр'), 'url' => array(
        '/shop/typeBackend/view',
        'id' => $model->id
    )),
    array('icon' => 'trash', 'label' => Yii::t('ShopModule.type', 'Удалить'), 'url' => '#', 'linkOptions' => array(
        'submit'  => array('/shop/typeBackend/delete', 'id' => $model->id),
        'params'  => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
        'confirm' => Yii::t('ShopModule.type', 'Удалить этот тип товара?'),
        'csrf'    => true,
    )),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ShopModule.type', 'Редактировать'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model, 'languages' => $languages, 'langModels' => $langModels, 'availableAttributes' => $availableAttributes)); ?>
