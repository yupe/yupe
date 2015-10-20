<?php /* @var $dataProvider CActiveDataProvider */ ?>
<div data-show='4' data-scroll='4' data-infinite="data-infinite" class="h-slider js-slick">
    <div class="h-slider__buttons">
        <div class="btn h-slider__control h-slider__next js-slick__next"></div>
        <div class="btn h-slider__control h-slider__prev js-slick__prev"></div>
    </div>
    <?php $this->widget(
        'zii.widgets.CListView',
        [
            'dataProvider' => $dataProvider,
            'template' => '{items}',
            'itemView' => '_item',
            'cssFile' => false,
            'pager' => false,
            'itemsCssClass' => 'h-slider__slides js-slick__container'
        ]
    ); ?>
</div>