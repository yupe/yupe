<?php $productUrl = Yii::app()->createUrl('/store/catalog/show', array('name' => CHtml::encode($data->alias))); ?>
<div class="col-sm-4">
    <div class="col-item">
        <div class="photo">
            <a href="<?= $productUrl; ?>">
                <img src="<?= $data->getImageUrl(190, 190, true); ?>"/>
            </a>
        </div>
        <div class="info separator">
            <div class="row">
                <div class="price col-sm-12">
                    <h5>
                        <a href="<?= $productUrl; ?>"><?= CHtml::encode($data->getName()); ?></a>
                    </h5>
                    <h5 class="price-text-color">
                        <?= floor($data->getResultPrice()); ?> <i class="fa fa-rub"></i>
                    </h5>
                </div>
            </div>
            <div class="separator clear-left">
                <?php if (Yii::app()->hasModule('cart')): ?>
                    <p class="btn-add">
                        <a href="#" class="hidden-sm quick-add-product-to-cart" data-product-id="<?= $data->id; ?>" data-cart-add-url="<?= Yii::app()->createUrl('/cart/cart/add');?>"><i class="glyphicon glyphicon-shopping-cart"></i></a>
                    </p>
                <?php endif; ?>
                <p class="btn-details">
                    <i class="glyphicon glyphicon-list"></i>
                    <a href="<?= $productUrl; ?>" class="hidden-sm">
                        <?= Yii::t("StoreModule.catalog", "Товар"); ?>
                    </a>
                </p>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
