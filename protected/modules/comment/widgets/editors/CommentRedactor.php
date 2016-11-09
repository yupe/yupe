<?php
namespace comment\widgets\editors;

use Yii;
use yupe\widgets\editors\Redactor as Redactor;

/**
 * Class CommentRedactor
 * @package comment\widgets\editors
 */
class CommentRedactor extends Redactor
{
    /**
     * @var array
     */
    public $options = [];

    /**
     * @return array
     */
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
            'lang'                  => strtolower(substr(Yii::app()->getLanguage(), -2)),
            'minHeight'             => 150,
            'uploadImageFields'     => [
                Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken
            ]
        ];
    }

    /**
     * @return array
     */
    public function getPlugins()
    {
        return [];
    }
}
