<?php
Yii::import('application.modules.feedback.FeedbackModule');
if (isset($models) && !empty($models)) {
    $this->widget(
        'bootstrap.widgets.TbPanel',
        [
            'title'      => Yii::t('FeedbackModule.feedback', 'FAQ'),
            'headerIcon' => 'glyphicon glyphicon-question-sign',
            'content'    => $this->render('_questions', ['models' => $models], true),
        ]
    );
}
