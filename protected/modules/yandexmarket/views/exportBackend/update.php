<?php
/* @var $model Export */

$this->breadcrumbs = [
    Yii::t('YandexMarketModule.default', 'Products export') => ['/yandexmarket/exportBackend/index'],
    Yii::t('YandexMarketModule.default', 'Edition'),
];

$this->pageTitle = Yii::t('YandexMarketModule.default', 'Products export - edition');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('YandexMarketModule.default', 'Manage export lists'), 'url' => ['/yandexmarket/exportBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('YandexMarketModule.default', 'Create export list'), 'url' => ['/yandexmarket/exportBackend/create']],
    ['label' => Yii::t('YandexMarketModule.default', 'Export list') . ' «' . mb_substr($model->name, 0, 32) . '»'],
    [
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('YandexMarketModule.default', 'Update export list'),
        'url' => [
            '/yandexmarket/exportBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('YandexMarketModule.default', 'Delete export list'),
        'url' => '#',
        'linkOptions' => [
            'submit' => ['/yandexmarket/exportBackend/delete', 'id' => $model->id],
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t('YandexMarketModule.default', 'Do you really want to remove this export list?'),
            'csrf' => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('YandexMarketModule.default', 'Updating export list'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
