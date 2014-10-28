<?php
$this->breadcrumbs = array(
    Yii::t('StoreModule.store', 'Магазин'),
);
$this->pageTitle = Yii::t('StoreModule.store', 'Магазин');
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t(
            'StoreModule.store',
            'Добро пожаловать в магазин "{app}"!',
            ['{app}' => CHtml::encode(Yii::app()->name)]
        ); ?>

    </h1>
</div>


<h1><small><?php echo Yii::t('StoreModule.store', 'Управление каталогом'); ?></small></h1>
<div class="shortcuts">
    <?php $navigation = $storeModule->getExtendedNavigation();?>
    <?php foreach ($navigation[0]['items'] as $item): ?>

        <a class="shortcut" href="<?php echo Yii::app()->createAbsoluteUrl(array_pop($item['url'])); ?>">
            <div class="cn">
                <i class="shortcut-icon <?php echo $item['icon'] ?>"></i>
                <span class="shortcut-label"><?php echo $item['label']; ?></span>
            </div>
        </a>

    <?php endforeach; ?>
</div>
