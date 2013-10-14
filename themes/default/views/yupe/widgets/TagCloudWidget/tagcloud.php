<?php
if (isset($tags) && !empty($tags)) {
    $this->widget(
        'bootstrap.widgets.TbBox',
        array(
            'title' => Yii::t('default','Tag cloud'),
            'headerIcon' => 'icon-tags',
            'content' => $this->render('_tags', array('tags' => $tags), true),
        )
    );
}




