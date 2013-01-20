<?php ?>
<?php
$this->renderPartial(
    Yii::app()->controller->action->id, array(
        'data' => isset($data) ? $data : array(),
    )
);?>