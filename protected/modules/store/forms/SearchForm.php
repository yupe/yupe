<?php

class SearchForm extends \CFormModel
{
    public $q;

    public $category;

    public function rules()
    {
        return [
            ['q', 'required'],
            ['category', 'numerical', 'integerOnly' => true]
        ];
    }
} 
