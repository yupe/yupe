<?php
namespace comment\widgets\editors;

use Yii;
use yupe\widgets\editors\Redactor as Redactor;

class CommentRedactor extends Redactor
{
    public $options = [];

    public function getOptions()
    {
        return [
            'buttonsHide'           => [
                'html',
                'formatting',
                'horizontalrule',
                'italic',
                'deleted',
                'unorderedlist',
                'orderedlist',
                'outdent',
                'indent',
                'alignment'
            ],
            'imageUpload'           => Yii::app()->createUrl('comment/comment/ajaxImageUpload'),
            'toolbarFixedTopOffset' => 53,
            'lang'                  => strtolower(substr(Yii::app()->language, -2)),
            'minHeight'             => 150,
            'uploadImageFields'     => [
                Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken
            ]
        ];
    }

    public function getPlugins()
    {
        return [];
    }
}
