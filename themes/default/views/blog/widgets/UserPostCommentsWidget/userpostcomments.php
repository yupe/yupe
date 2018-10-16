<?php
$this->widget(
    'booster.widgets.TbListView',
    [
        'dataProvider' => $dataProvider,
        'itemView' => '_comment',
        'summaryText' => false,
    ]
);
