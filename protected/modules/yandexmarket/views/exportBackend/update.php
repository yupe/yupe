<?php
/* @var $model Export */

$this->breadcrumbs = [
    Yii::t('YandexMarketModule.default', 'Экспорт товаров') => ['/yandexmarket/exportBackend/index'],
    Yii::t('YandexMarketModule.default', 'Редактировать'),
];

$this->pageTitle = Yii::t('YandexMarketModule.default', 'Выгрузка товаров - редактировать');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('YandexMarketModule.default', 'Управление'), 'url' => ['/yandexmarket/exportBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('YandexMarketModule.default', 'Добавить'), 'url' => ['/yandexmarket/exportBackend/create']],
    ['label' => Yii::t('YandexMarketModule.default', 'Выгрузка товаров') . ' «' . mb_substr($model->name, 0, 32) . '»'],
    [
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('YandexMarketModule.default', 'Редактировать'),
        'url' => [
            '/yandexmarket/exportBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('YandexMarketModule.default', 'Удалить'),
        'url' => '#',
        'linkOptions' => [
            'submit' => ['/yandexmarket/exportBackend/delete', 'id' => $model->id],
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t('YandexMarketModule.default', 'Удалить эту выгрузку товаров?'),
            'csrf' => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('YandexMarketModule.default', 'Редактировать'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
