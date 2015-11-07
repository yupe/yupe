<?php
/**
 * @var array $brands
 * @var Producer $brand
 */
?>
<?php if ($brands): ?>
    <div class="row">
        <div class="col-sm-12">
            <div id="brand-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner" role="listbox">
                    <?php foreach ($brands as $i => $brand): ?>
                        <div class="item <?= $i == 0 ? 'active' : '' ?>">
                            <div class="scrollElement__item" data-target="#carousel">
                                <?php $this->render('_item', ['brand' => $brand]) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <a class="left carousel-control" href="#brand-carousel" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                </a>
                <a class="right carousel-control" href="#brand-carousel" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>
