<?php if(false === $favorite->has($product->id)):?>
    <div class="product-vertical-extra__button yupe-store-favorite-add" data-id="<?= $product->id;?>"><i class="fa fa-heart-o"></i></div>
<?php else:?>
    <div class="product-vertical-extra__button yupe-store-favorite-remove text-error" data-id="<?= $product->id;?>"><i class="fa fa-heart"></i></div>
<?php endif;?>