<?php
if (isset($models) && !empty($models)) {
    $this->widget(
        'bootstrap.widgets.TbBox',
        array(
            'title' => 'Блоги',
            'headerIcon' => 'icon-pencil',
            'content' => $this->render('_blogs', array('models' => $models), true),
        )
    );
}







