<?php
Yii::import('application.modules.feedback.FeedbackModule');
if (isset($models) && !empty($models)) {
    $this->widget(
        'bootstrap.widgets.TbBox',
        array(
            'title' => Yii::t('FeedbackModule.feedback','FAQ'),
            'headerIcon' => 'icon-question-sign',
            'htmlHeaderOptions' => array(
            	'class' => 'yupe-widget-header'
             ),
            'content' => $this->render('_questions', array('models' => $models), true),
        )
    );
}



