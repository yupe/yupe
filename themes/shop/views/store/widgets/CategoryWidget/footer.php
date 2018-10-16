<?php
$this->widget('zii.widgets.CMenu', [
    'items' => $tree,
    'itemTemplate' => '<div class="footer__item">{menu}</div>',
    'htmlOptions' => $htmlOptions
]);
