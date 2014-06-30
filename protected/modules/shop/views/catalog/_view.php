<div class="col-item span4">
    <div class="photo">
        <img src="<?php echo ($data->mainImage ? $data->mainImage->getImageUrl(190, 190, true) : ''); ?>" class="img-responsive" alt=""/>
    </div>
    <div class="info separator">
        <div class="row-fluid">
            <div class="price span12">
                <h5>
                    <a href="<?php echo Yii::app()->createUrl('/shop/catalog/show', array('name' => $data->alias)); ?>"><?php echo CHtml::encode($data->name); ?></a>
                </h5>
                <h5 class="price-text-color">
                    <?php echo floor($data->getResultPrice()); ?> <i class="fa fa-rub"></i>
                </h5>
            </div>
            <!--            <div class="rating hidden span6">
                            <i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">
                            </i><i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">
                            </i><i class="fa fa-star"></i>
                        </div>-->
        </div>
        <div class="separator clear-left">
            <p class="btn-add">
                <i class="fa fa-shopping-cart"></i>
                <a href="#" class="hidden-sm quick-add-product-to-cart" data-product-id="<?php echo $data->id; ?>">Добавить</a>
            </p>

            <p class="btn-details">
                <i class="fa fa-list"></i><a href="<?php echo Yii::app()->createUrl('/shop/catalog/show', array('name' => $data->alias)); ?>" class="hidden-sm">Товар</a>
            </p>
        </div>
        <div class="clearfix">
        </div>
    </div>
</div>