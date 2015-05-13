<div class="panel panel-default" id="cart-widget" data-cart-widget-url="<?= Yii::app()->createUrl('/cart/cart/widget');?>">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-shopping-cart"></i>
            <?= Yii::t('CartModule.cart', 'Cart'); ?>
        </div>
    </div>
    <div class="panel-body">
        <?php if (Yii::app()->cart->isEmpty()): ?>
            <?= Yii::t("CartModule.cart", "There are no products in cart"); ?>
        <?php else: ?>
            <div class="row">
                <div class="col-sm-12">
                    <?php $count = Yii::app()->cart->getCount(); ?>
                    <p>
                        <?= Yii::t('CartModule.cart', '{n} product|{n} products|{n} products|{n} products', $count); ?>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-6">
                            <p>
                                <?= Yii::t("CartModule.cart", "Sum"); ?>:
                            </p>
                        </div>
                        <div class="col-sm-6 text-right">
                            <p>
                                <?= Yii::app()->cart->getCost(); ?>
                                <?= Yii::t("CartModule.cart", "RUB"); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <a href="<?= Yii::app()->createUrl('cart/cart/index'); ?>" class="btn btn-default btn-sm">
                        <?= Yii::t("CartModule.cart", "Go to cart"); ?> <i class="glyphicon glyphicon-shopping-cart"></i>
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
