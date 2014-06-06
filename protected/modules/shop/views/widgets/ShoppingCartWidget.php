<div class="bootstrap-widget" id="<?php echo $id;?>">
    <div class="yupe-widget-header">
        <i class="icon-shopping-cart"></i>
        <h3>Корзина</h3>
    </div>
    <div class="yupe-widget-content">
        <div class="row-fluid">
            <div class="span12">
                <?php $count = Yii::app()->shoppingCart->getCount(); ?>
                <?php echo Yii::t('default', '{n} товар|{n} товара|{n} товаров|{n} товара', $count); ?>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12">
                <span class="span6">Сумма:</span>
                <span class="span6 text-right"><?php echo Yii::app()->shoppingCart->getCost(); ?> руб.</span>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span12 text-center">
                <a href="<?php echo Yii::app()->createUrl('shop/cart/index'); ?>" class="btn btn-small">Перейти в корзину <i class="icon-shopping-cart"></i></a>
            </div>
        </div>
    </div>
</div>