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
 * 
 * 
 * @modified ApexWire <apewire@gmail.com>
 * 1) подправлен баг с отсутствием toolbar.
 * 2) модальное окно загрузки изображения, кнопка "Вставить", перенесена во вкладку "Ссылка", убрана из вкладки "Загрузить" - так как является лишней из за ненужности
 * 3) удален файл lang/en.js за ненадобностью, так как английский уже встроен в файл и является языком по умолчанию
 * 4) путь '/index.php/yupe/backend/AjaxFileUpload/' внесен в переменные, добавленна опция 'upload', если она указана то прописывается путь загрузки файлов для изображений и файлов
 * 5) добавлена функция setOptions, в которую перенесена установка опций.
 * 6) загрузка файлов в BackendController 
 * 		изменена строка:
 * 		Yii::app()->ajax->rawText(CJSON::encode(array('filelink' => Yii::app()->baseUrl . $webPath . $newFileName)));
 * 		на:
 * 		Yii::app()->ajax->rawText(CJSON::encode(array(
        	'filelink' => Yii::app()->baseUrl . $webPath . $newFileName,
            'filename' => $image->name
        )));
        чтобы возвращать название файла
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
	
	/**
	 * @var string default buttons
	 */
	public $uploadPath = '/index.php/yupe/backend/AjaxFileUpload/';

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

		$this->setOptions();
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
	
	protected function setOptions()
	{
		if(isset($this->options['path']))
			$this->options['path']=rtrim($this->options['path'],'/\\').'/';
		
		if( isset($this->options['toolbar']) AND isset($this->buttons[$this->options['toolbar']]) )
			$this->options['buttons'] = $this->buttons[$this->options['toolbar']];
		
		
		if(isset($this->options['toolbar']))
			unset($this->options['toolbar']);
		
		if($this->lang)
			$this->options['lang'] = $this->lang;
		
		if(!isset($this->options['autoresize']))
			$this->options['autoresize'] = false;
		
		if ( isset($this->options['upload']) AND $this->options['upload'] ) {
			$this->options['imageUpload'] = $this->uploadPath;
			$this->options['fileUpload'] = $this->uploadPath;
		}
	}
	
	/**
	 * Register CSS and Script.
	 */
	protected function registerClientScript()
	{
		$cs=Yii::app()->getClientScript();
		$cs->registerCssFile($this->cssFile);
		$cs->registerCoreScript('jquery');
		$cs->registerScriptFile($this->scriptFile);
		
		if($this->scriptLangFile)
			$cs->registerScriptFile($this->scriptLangFile);
		$cs->registerScript(__CLASS__.'#'.$this->id,'jQuery("#'.$this->id.'").redactor('.CJavaScript::encode($this->options).');');
	}
}
