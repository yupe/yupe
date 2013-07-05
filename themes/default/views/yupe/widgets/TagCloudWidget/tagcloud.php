<?php
if (isset($tags) && !empty($tags)) {
    $this->widget(
        'bootstrap.widgets.TbBox',
        array(
            'title' => 'Облако меток',
            'headerIcon' => 'icon-tags',
            'content' => $this->render('_tags', array('tags' => $tags), true),
        )
    );
}




