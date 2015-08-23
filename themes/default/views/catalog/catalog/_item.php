<?php
/**
 * @var $this CatalogController
 * @var $data Good
 */
?>
<div class="col-sm-4">
    <div class="col-item">
        <div class="photo">
            <?= CHtml::link(CHtml::image($data->getImageUrl(190, 190), $data->name), $data->getUrl()) ?>
        </div>
        <div class="info separator">
            <div class="row form-group">
                <div class="price col-sm-12">
                    <h5>
                        <?= CHtml::link($data->name, $data->getUrl()); ?>
                    </h5>
                    <h5 class="price-text-color">
                        <?= number_format($data->price, 2, ',', ' '); ?> <i class="fa fa-rub"></i>
                    </h5>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
