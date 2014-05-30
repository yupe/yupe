<?php if($dataProvider->itemCount):?>
        <div id="myCarousel" class="carousel slide">
            <!-- Carousel items -->
            <div class="carousel-inner">
                <div class="item active">
                    <div class="row-fluid">
                        <?php foreach($dataProvider->getData() as $data):?>
                            <div class="span3">
                                <a href="<?php echo Yii::app()->createUrl('/gallery/gallery/image/',array('id' => $data->image->id));?>" class="thumbnail">
                                   <?php echo CHtml::image($data->image->getUrl(250, 250), $data->image->alt, array('width' => 250, 'height' => 250,'href' => $data->image->getUrl(),'class' => 'gallery-image')); ?>
                                </a>
                            </div>
                        <?php endforeach;?>
                    </div><!--/row-fluid-->
                </div><!--/item-->
            </div><!--/carousel-inner-->
        </div><!--/myCarousel-->
<?php endif;?>