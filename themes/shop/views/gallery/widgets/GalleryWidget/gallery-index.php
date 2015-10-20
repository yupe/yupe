<?php if ($dataProvider->itemCount): ?>
    <div id="myCarousel" class="carousel slide">
        <!-- Carousel items -->
        <div class="carousel-inner">
            <div class="item active">
                <div class="row">
                    <?php foreach ($dataProvider->getData() as $data): ?>
                        <div class="col-sm-3">
                            <a href="<?= $data->image->getUrl(); ?>" class="thumbnail">
                                <?= CHtml::image(
                                    $data->image->getImageUrl(250, 250),
                                    $data->image->alt,
                                    [
                                        'width'  => 250,
                                        'height' => 250,
                                        'href'   => $data->image->getImageUrl(),
                                        'class'  => 'gallery-image'
                                    ]
                                ); ?>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!--/row-fluid-->
            </div>
            <!--/item-->
        </div>
        <!--/carousel-inner-->
    </div><!--/myCarousel-->
<?php endif; ?>
