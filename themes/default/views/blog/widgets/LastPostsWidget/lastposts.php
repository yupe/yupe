<?php
Yii::import('application.modules.blog.BlogModule');
if (isset($models) && !empty($models)) {
    $this->widget(
        'bootstrap.widgets.TbBox',
        array(
            'title' => Yii::t('BlogModule.blog','Last in blogs'),
            'headerIcon' => 'icon-pencil',
            'content' => $this->render('_links', array('models' => $models), true),
        )
    );
}


