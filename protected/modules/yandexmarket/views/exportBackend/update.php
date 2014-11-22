<?php
/* @var $model Export */

$this->breadcrumbs = array(
    Yii::t('YandexMarketModule.default', 'Экспорт товаров') => array('/yandexmarket/exportBackend/index'),
    $model->name => array('/yandexmarket/exportBackend/view', 'id' => $model->id),
    Yii::t('YandexMarketModule.default', 'Редактировать'),
);

$this->pageTitle = Yii::t('YandexMarketModule.default', 'Выгрузка товаров - редактировать');

$this->menu = array(
    array('icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('YandexMarketModule.default', 'Управление'), 'url' => array('/yandexmarket/exportBackend/index')),
    array('icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('YandexMarketModule.default', 'Добавить'), 'url' => array('/yandexmarket/exportBackend/create')),
    array('label' => Yii::t('YandexMarketModule.default', 'Выгрузка товаров') . ' «' . mb_substr($model->name, 0, 32) . '»'),
    array(
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('YandexMarketModule.default', 'Редактировать'),
        'url' => array(
            '/yandexmarket/exportBackend/update',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('YandexMarketModule.default', 'Просмотр'),
        'url' => array(
            '/yandexmarket/exportBackend/view',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('YandexMarketModule.default', 'Удалить'),
        'url' => '#',
        'linkOptions' => array(
            'submit' => array('/yandexmarket/exportBackend/delete', 'id' => $model->id),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t('YandexMarketModule.default', 'Удалить эту выгрузку товаров?'),
            'csrf' => true,
        )
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('YandexMarketModule.default', 'Редактировать'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
