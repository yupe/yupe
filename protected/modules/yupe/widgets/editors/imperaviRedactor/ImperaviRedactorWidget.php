<?php
/**
 * ImperaviRedactorWidget class file.
 *
 * @author Veaceslav Medvedev <slavcopost@gmail.com>
 * @author Alexander Makarov <sam@rmcreative.ru>
 *
 * @version 1.0
 *
 * @link https://github.com/yiiext/imperavi-redactor-widget
 * @license https://github.com/yiiext/imperavi-redactor-widget/blob/master/license.md
 */
class ImperaviRedactorWidget extends \CInputWidget
{
    /**
     * Assets package ID.
     */
    const PACKAGE_ID = 'imperavi-redactor';

    /**
     * @var array {@link http://imperavi.com/redactor/docs/ redactor options}.
     */
    public $options = array();

    /**
     * @var string|null Selector pointing to textareas to initialize redactor for.
     * Defaults to null meaning that textarea doesn't exist yet and will be
     * rendered by this widget.
     */
    public $selector;

    /**
     * Init widget.
     */
    public function init()
    {
        parent::init();

        if ($this->selector === null) {
            list($this->name, $this->id) = $this->resolveNameId();
            $this->selector = '#' . $this->id;

            if ($this->hasModel()) {
                echo CHtml::activeTextArea($this->model, $this->attribute, $this->htmlOptions);
            } else {
                $this->htmlOptions['id'] = $this->id;
                echo CHtml::textArea($this->name, $this->value, $this->htmlOptions);
            }
        }

        $this->registerClientScript();
    }

    /**
     * Register CSS and Script.
     */
    protected function registerClientScript()
    {
        /** @var $cs CClientScript */
        $cs = Yii::app()->clientScript;
        if (!isset($cs->packages[self::PACKAGE_ID])) {
            /** @var $am CAssetManager */
            $am = Yii::app()->assetManager;
            $cs->packages[self::PACKAGE_ID] = array(
                'basePath' => dirname(__FILE__) . '/assets',
                'baseUrl' => $am->publish(dirname(__FILE__) . '/assets'),
                'js' => array(
                    'redactor' . (YII_DEBUG ? '' : '.min') . '.js',
                ),
                'css' => array(
                    'redactor.css',
                ),
                'depends' => array(
                    'jquery',
                ),
            );
        }
        $cs->registerPackage(self::PACKAGE_ID);

        $cs->registerScript(
            $this->id,
            'jQuery(' . CJavaScript::encode($this->selector) . ').redactor(' . CJavaScript::encode($this->options) . ');',
            CClientScript::POS_READY
        );
    }
}