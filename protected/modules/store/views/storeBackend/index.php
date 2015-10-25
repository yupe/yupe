<?php
$this->breadcrumbs = [
    Yii::t('StoreModule.store', 'Store'),
];
$this->pageTitle = Yii::t('StoreModule.store', 'Store');
?>
<div class="page-header">
    <h1>
        <?= Yii::t(
            'StoreModule.store',
            'Welcome to "{app}" store!',
            ['{app}' => CHtml::encode(Yii::app()->name)]
        ); ?>

    </h1>
</div>


<h1><small><?= Yii::t('StoreModule.store', 'Catalog manage'); ?></small></h1>
<div class="shortcuts">
    <?php $navigation = $storeModule->getExtendedNavigation();?>
    <?php foreach ($navigation[0]['items'] as $item): ?>

        <a class="shortcut" href="<?= Yii::app()->createAbsoluteUrl(array_pop($item['url'])); ?>">
            <div class="cn">
                <i class="shortcut-icon <?= $item['icon'] ?>"></i>
                <span class="shortcut-label"><?= $item['label']; ?></span>
            </div>
        </a>

    <?php endforeach; ?>
</div>
