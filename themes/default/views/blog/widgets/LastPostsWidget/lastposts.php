<?php
if (isset($models) && !empty($models)) {
    $this->widget(
        'bootstrap.widgets.TbBox',
        array(
            'title' => 'Последнее в блогах',
            'headerIcon' => 'icon-pencil',
            'content' => $this->render('_links', array('models' => $models), true),
        )
    );
}


