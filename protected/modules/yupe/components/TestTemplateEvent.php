<?php

namespace yupe\components;

class TestTemplateEvent {

    public static function onBodyEnd()
    {
        //render custom html content
        echo '!!!';
    }

}