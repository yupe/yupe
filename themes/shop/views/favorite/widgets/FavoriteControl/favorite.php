<?php if($favorite->has($product) === false):?>
    <div class="product-vertical-extra__button yupe-store-favorite-add" data-id="<?= $product->id;?>"><i class="fa fa-heart-o"></i></div>
<?php endif;?>