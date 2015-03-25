<?php
/**
 * @var $this CatalogController
 * @var $data Good
 */
?>
<div class="post">
    <div class="title">
        <?php echo CHtml::link(CHtml::encode($data->name), $data->getUrl()); ?>
    </div>
    <br/>

    <div class="content">
        <p><?php echo $data->short_description; ?></p>
    </div>
    <div class="nav">
        <?php echo Yii::t('CatalogModule.catalog', 'Price') . ': ';
        echo $data->price; ?>
        <br/>
        <?php echo CHtml::link(
            Yii::t('CatalogModule.catalog', 'Constant link'),
            $data->getUrl()
        ); ?>
    </div>
</div>
