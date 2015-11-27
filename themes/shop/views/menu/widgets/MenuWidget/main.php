<?php
$this->widget('zii.widgets.CMenu', [
    'items' => $this->params['items'],
    'itemCssClass' => 'top-menu__item',
    'htmlOptions' => [
        'class' => 'top-menu'
    ],
    'submenuHtmlOptions' => [
        'class' => 'dropdown-menu'
    ]
]);
