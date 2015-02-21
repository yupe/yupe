<?php
/* @var $model Export */

$this->breadcrumbs = [
    Yii::t('YandexMarketModule.default', 'Products export') => ['/yandexmarket/exportBackend/index'],
    Yii::t('YandexMarketModule.default', 'Creating'),
];

$this->pageTitle = Yii::t('YandexMarketModule.default', 'Products export - creating');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('YandexMarketModule.default', 'Manage export lists'), 'url' => ['/yandexmarket/exportBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('YandexMarketModule.default', 'Create export list'), 'url' => ['/yandexmarket/exportBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('YandexMarketModule.default', 'Products export'); ?>
        <small><?php echo Yii::t('YandexMarketModule.default', 'creating'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
