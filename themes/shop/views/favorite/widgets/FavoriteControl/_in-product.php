<?php if(false === $favorite->has($product->id)):?>
    <a href="javascript:void(0);" class="entry__toolbar-button yupe-store-favorite-add" data-id="<?= $product->id;?>"><i class="fa fa-heart-o"></i></a>
<?php else:?>
    <a href="javascript:void(0);" class="entry__toolbar-button yupe-store-favorite-remove text-error" data-id="<?= $product->id;?>"><i class="fa fa-heart"></i></a>
<?php endif;?>
