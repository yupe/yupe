<?php

class ImageGroupHelper
{
    public static function all()
    {
        return CHtml::listData(ImageGroup::model()->findAll(), 'id', 'name');
    }
}