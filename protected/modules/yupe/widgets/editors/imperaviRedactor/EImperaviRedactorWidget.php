<?php
/**
 * EImperaviRedactorWidget class file.
 *
 * @author Veaceslav Medvedev <slavcopost@gmail.com>
 * @modified Alexander Tischenko <tsm@archaron.ru>
 * @link http://code.google.com/p/yiiext/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */
/**
 * EImperaviRedactorWidget adds {@link http://imperavi.ru/redactor/ imperavi redactor} as a form field widget.
 *
 * Usage:
 * <pre>
 * $this->widget('ext.yiiext.widgets.imperaviRedactor.EImperaviRedactorWidget',array(
 *     // you can either use it for model attribute
 *     'model'=>$my_model,
 *     'lang' => 'ru',
 *     'attribute'=>'my_field',
 *     // or just for input field
 *     'name'=>'my_input_name',
 *     // imperavi redactor {@link http://imperavi.ru/redactor/docs/ options}
 *     'options'=>array(
 *         'toolbar'=>'main', // 'mini' or null
 *         'cssPath'=>Yii::app()->theme->baseUrl.'/css/',
 *     ),
 * ));
 * </pre>

 * @author Veaceslav Medvedev <slavcopost@gmail.com>
 * @version 0.4
 * @package yiiext.widgets.imperaviRedactor
 * @modified Alexander Tischenko <tsm@archaron.ru>
 * @link http://imperavi.ru/redactor/
 */
class EImperaviRedactorWidget extends CInputWidget
{
	/**
	 * @var string URL where to look imperavi redactor assets.
	 */
	public $assetsUrl;
	/**
	 * @var string imperavi redactor script name.
	 */
	public $scriptFile;
	/**
	 * @var string imperavi redactor stylesheet.
	 */
	public $cssFile;
	/**
	 * @var array imperavi redactor {@link http://imperavi.ru/redactor/docs/ options}.
	 */
	public $options=array();

	public $lang;

	protected $scriptLangFile;

	protected $buttons = array (
		'mini' => array("formatting", "|", "bold", "italic", "deleted", "|", "unorderedlist", "orderedlist"),
		'main' => array('html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|', 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'image', 'video', 'file', 'table', 'link', '|', 'fontcolor', 'backcolor', '|',  'alignleft', 'aligncenter', 'alignright', 'justify', '|', 'horizontalrule'),
	);
	/**
	 * Init widget.
	 */
	public function init()
	{
		list($this->name,$this->id)=$this->resolveNameId();

		if(!$this->lang) $this->lang=Yii::app()->language;

		if($this->assetsUrl===null)
			$this->assetsUrl=Yii::app()->getAssetManager()->publish(dirname(__FILE__).'/assets',false,-1,YII_DEBUG);

		if($this->scriptFile===null)
			$this->scriptFile=$this->assetsUrl.'/'.(YII_DEBUG ? 'redactor.js' : 'redactor.min.js');

		if(is_file(dirname(__FILE__).'/assets/langs/'.$this->lang.".js"))
			$this->scriptLangFile=$this->assetsUrl.'/langs/'.$this->lang.".js";
		else		
		{	$this->scriptLangFile=null; $this->lang=null; }

		if($this->cssFile===null)
			$this->cssFile=$this->assetsUrl.'/css/redactor.css';

		$this->registerClientScript();
	}

	/**
	 * Run widget.
	 */
	public function run()
	{
		if($this->hasModel())
			echo CHtml::activeTextArea($this->model,$this->attribute,$this->htmlOptions);
		else
			echo CHtml::textArea($this->name,$this->value,$this->htmlOptions);
	}
	/**
	 * Register CSS and Script.
	 */
	protected function registerClientScript()
	{
		if(isset($this->options['path']))
			$this->options['path']=rtrim($this->options['path'],'/\\').'/';

		if(isset($this->options['toolbar']) || !isset($this->buttons[$this->options['toolbar']]))
			$this->options['buttons'] = $this->buttons[$this->options['toolbar']];		

		if(isset($this->options['toolbar']))
			unset($this->options['toolbar']);

		if($this->lang)
			$this->options['lang'] = $this->lang;		

		if(!isset($this->options['autoresize']))
			$this->options['autoresize'] = false;

		$cs=Yii::app()->getClientScript();
		$cs->registerCssFile($this->cssFile);
		$cs->registerCoreScript('jquery');
		$cs->registerScriptFile($this->scriptFile);

		if($this->scriptLangFile)
			$cs->registerScriptFile($this->scriptLangFile);
		$cs->registerScript(__CLASS__.'#'.$this->id,'jQuery("#'.$this->id.'").redactor('.CJavaScript::encode($this->options).');');
	}
}
