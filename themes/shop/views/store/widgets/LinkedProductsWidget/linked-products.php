<div class="main__recently-viewed-slider">
    <div class="grid">
        <div class="h3">Похожие товары</div>
        <div data-show='3' data-scroll='3' data-infinite="data-infinite" class="h-slider js-slick">
            <div class="h-slider__buttons h-slider__buttons_noclip">
                <div class="btn h-slider__control h-slider__next js-slick__next slick-arrow" style="display: block;"></div>
                <div class="btn h-slider__control h-slider__prev js-slick__prev slick-arrow" style="display: block;"></div>
            </div>
                <?php $this->widget('zii.widgets.CListView', [
                    'dataProvider' => $dataProvider,
                    'template' => '{items}',
                    'itemView' => '_item',
                    'itemsCssClass' => 'h-slider__slides js-slick__container',
                    'cssFile' => false,
                    'pager' => false,
                ]); ?>
        </div>
    </div>
</div>
