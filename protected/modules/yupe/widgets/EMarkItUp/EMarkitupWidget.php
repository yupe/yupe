<?php
/**
 * EMarkitupWidget adds {@link http://markitup.jaysalvat.com/ markitup} as a form field widget.
 *
 * @author creocoder <creocoder@gmail.com>
 * @license http://www.opensource.org/licenses/bsd-license.php
 * @version 1.1
 * @package yiiext.widgets.markitup
 * @link http://code.google.com/p/yiiext/
 * @link http://markitup.jaysalvat.com/
 */
class EMarkitupWidget extends CInputWidget
{
    /**
     * @var string URL where to look for markItUp assets.
     */
    public $scriptUrl;
    /**
     * @var string markItUp script name.
     * Defaults to jquery.markitup.js or jquery.markitup.min.js depending on YII_DEGUG.
     */
    public $scriptFile;
    /**
     * @var string URL where to look for a skin.
     */
    public $themeUrl;
    /**
     * @var string markItUp skin name. Simple and markitup are available by default. Defaults to simple.
     */
    public $theme = 'simple';
    /**
     * @var string URL where to look for a tag set.
     */
    public $settingsUrl;
    /**
     * @var string tag set name. Html and markdown are available by default. Defaults to html.
     */
    public $settings = 'html';
    /**
     * @var array {@link http://markitup.jaysalvat.com/documentation/ markitup options}.
     */
    public $options = array();

    /**
     * Init widget.
     */
    public function init()
    {
        list($this->name, $this->id) = $this->resolveNameId();

        if ($this->scriptUrl === null)
            $this->scriptUrl = Yii::app()->getAssetManager()->publish(dirname(__FILE__) .DIRECTORY_SEPARATOR. 'assets', false, -1, YII_DEBUG);

        if ($this->themeUrl === null)
            $this->themeUrl = $this->scriptUrl.DIRECTORY_SEPARATOR.'skins';

        if ($this->settingsUrl === null)
            $this->settingsUrl = $this->scriptUrl.DIRECTORY_SEPARATOR.'sets';

        if ($this->scriptFile === null)
            $this->scriptFile = YII_DEBUG ? 'jquery.markitup.js'
                : 'jquery.markitup.min.js';

        $this->registerClientScript();
    }

    /**
     * Run widget.
     */
    public function run()
    {
        if ($this->hasModel())
            echo CHtml::activeTextArea($this->model, $this->attribute, $this->htmlOptions);
        else
            echo CHtml::textArea($this->name, $this->value, $this->htmlOptions);
    }

    /**
     * Register CSS and Scripts.
     */
    protected function registerClientScript()
    {
        $id = $this->id;
        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        $cs->registerScriptFile($this->scriptUrl .DIRECTORY_SEPARATOR. $this->scriptFile);
        $cs->registerScriptFile($this->settingsUrl .DIRECTORY_SEPARATOR. $this->settings.DIRECTORY_SEPARATOR.'set.js');

        $options = CJavaScript::encode($this->options);
        $cs->registerScript(__CLASS__ . '#' . $id, "jQuery('#$id').markItUp(mySettings,$options).css('height', function() {
																	var h = jQuery(this).css('line-height').match(/(\d+)(.*)/)																	
																	return (h[1]*jQuery(this).attr('rows'))+h[2]
																  });");

        $cs->registerCssFile($this->themeUrl.DIRECTORY_SEPARATOR.$this->theme.DIRECTORY_SEPARATOR.'style.css');
        $cs->registerCssFile($this->settingsUrl.DIRECTORY_SEPARATOR.$this->settings.DIRECTORY_SEPARATOR.'style.css');
    }
}
