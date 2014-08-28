<?php
Yii::import('application.modules.feedback.FeedbackModule');
if (isset($models) && !empty($models)) {
    $this->widget(
        'bootstrap.widgets.TbPanel',
        array(
            'title'      => Yii::t('FeedbackModule.feedback', 'FAQ'),
            'headerIcon' => 'glyphicon glyphicon-question-sign',
            'content'    => $this->render('_questions', array('models' => $models), true),
        )
    );
}
