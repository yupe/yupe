<?php
/* @var $model Export */

$this->breadcrumbs = [
    Yii::t('YandexMarketModule.default', 'Экспорт товаров') => ['/yandexmarket/exportBackend/index'],
    Yii::t('YandexMarketModule.default', 'Добавить'),
];

$this->pageTitle = Yii::t('YandexMarketModule.default', 'Выгрузка товаров - добавить');

$this->menu = [
    ['icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('YandexMarketModule.default', 'Управление'), 'url' => ['/yandexmarket/exportBackend/index']],
    ['icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('YandexMarketModule.default', 'Добавить'), 'url' => ['/yandexmarket/exportBackend/create']],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('YandexMarketModule.default', 'Выгрузка'); ?>
        <small><?php echo Yii::t('YandexMarketModule.default', 'добавить'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
