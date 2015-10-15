<?php
/**
 * @var StoreCategory $category
 * @var array $products Product objects array
 * @var Product $product
 */
?>
<div class="row">
    <div class="col-sm-12">
        <div id="carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
                <?php foreach ($products as $i => $product): ?>
                    <div class="item <?= $i == 0 ? 'active' : '' ?>">
                        <div class="scrollElement__item" data-target="#carousel">
                            <?php $this->render('_item', ['product' => $product]) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            </a>
            <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            </a>
        </div>
    </div>
</div>
