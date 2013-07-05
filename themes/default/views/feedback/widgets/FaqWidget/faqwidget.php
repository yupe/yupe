<?php
if (isset($models) && !empty($models)) {
    $this->widget(
        'bootstrap.widgets.TbBox',
        array(
            'title' => 'Вопросы и ответы',
            'headerIcon' => 'icon-question-sign',
            'content' => $this->render('_questions', array('models' => $models), true),
        )
    );
}



