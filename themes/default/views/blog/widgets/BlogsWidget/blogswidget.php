<?php
Yii::import('application.modules.blog.BlogModule');
if (isset($models) && !empty($models)) {
    $this->widget(
        'bootstrap.widgets.TbBox',
        array(
            'title' => Yii::t('BlogModule.blog','Blogs'),
            'headerIcon' => 'icon-pencil',
            'content' => $this->render('_blogs', array('models' => $models), true),
        )
    );
}







