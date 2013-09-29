<?php
return array(
    'module'   => array(
        'class' => 'application.modules.comment.CommentModule',
    ),
    'import'    => array(
        'application.modules.comment.*',
        'application.modules.comment.models.*',
        'application.modules.yupe.extensions.nested-set-behavior.NestedSetBehavior',
    ),
    'component' => array(),
    'rules'     => array(),
);