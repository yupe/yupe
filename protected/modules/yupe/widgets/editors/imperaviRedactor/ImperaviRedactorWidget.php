<?php
/**
 * ImperaviRedactorWidget class file.
 *
 * @property string $assetsPath
 * @property string $assetsUrl
 * @property array $plugins
 *
 * @author Veaceslav Medvedev <slavcopost@gmail.com>
 * @author Alexander Makarov <sam@rmcreative.ru>
 *
 * @version 1.2.4
 *
 * @link https://github.com/yiiext/imperavi-redactor-widget
 * @link http://imperavi.com/redactor
 * @license https://github.com/yiiext/imperavi-redactor-widget/blob/master/license.md
 */
class ImperaviRedactorWidget extends CInputWidget
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
	 * @var string|null Selector pointing to textarea to initialize redactor for.
	 * Defaults to null meaning that textarea does not exist yet and will be
	 * rendered by this widget.
	 */
	public $selector;

	/**
	 * @var array
	 */
	public $package = array();

	/**
	 * @var array
	 */
	private $_plugins = array();

	/**
	 * Init widget.
	 */
	public function init()
	{
		parent::init();

		if ($this->selector === null) {
			list($this->name, $this->id) = $this->resolveNameID();
			$this->htmlOptions['id'] = $this->getId();
			$this->selector = '#' . $this->getId();

			if ($this->hasModel()) {
				echo CHtml::activeTextArea($this->model, $this->attribute, $this->htmlOptions);
			} else {
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
		// Prepare script package.
		$this->package = array_merge(array(
				'baseUrl' => $this->getAssetsUrl(),
				'js' => array(
					YII_DEBUG ? 'redactor.js' : 'redactor.min.js',
				),
				'css' => array(
					'redactor.css',
				),
				'depends' => array(
					'jquery',
				),
			), $this->package);

		// Append language file to script package.
		if (isset($this->options['lang']) && $this->options['lang'] !== 'en') {
			$this->package['js'][] = 'lang/' . $this->options['lang'] . '.js';
		}

		// Add assets url to relative css.
		if (isset($this->options['css'])) {
			if (!is_array($this->options['css'])) {
				$this->options['css'] = array($this->options['css']);
			}
			foreach ($this->options['css'] as $i => $css) {
				if (strpos($css, '/') === false) {
					$this->options['css'][$i] = $this->getAssetsUrl() . '/' . $css;
				}
			}
		}

		// Insert plugins in options
		if (!empty($this->_plugins)) {
			$this->options['plugins'] = array_keys($this->_plugins);
		}

		$clientScript = Yii::app()->getClientScript();
		$selector = CJavaScript::encode($this->selector);
		$options = CJavaScript::encode($this->options);

		$clientScript
			->addPackage(self::PACKAGE_ID, $this->package)
			->registerPackage(self::PACKAGE_ID)
			->registerScript(
				$this->id,
				'jQuery(' . $selector . ').redactor(' . $options . ');',
				CClientScript::POS_READY
			);

		foreach ($this->getPlugins() as $id => $plugin) {
			$clientScript
				->addPackage(self::PACKAGE_ID . '-' . $id, $plugin)
				->registerPackage(self::PACKAGE_ID . '-' . $id);
		}
	}

	/**
	 * Get the assets path.
	 * @return string
	 */
	public function getAssetsPath()
	{
		return  dirname(__FILE__) . '/assets';
	}

	/**
	 * Publish assets and return url.
	 * @return string
	 */
	public function getAssetsUrl()
	{
		return Yii::app()->getAssetManager()->publish($this->getAssetsPath());
	}

	/**
	 * @param array $plugins
	 */
	public function setPlugins(array $plugins)
	{
		foreach ($plugins as $id => $plugin) {
			if (!isset($plugin['baseUrl'], $plugin['basePath'])) {
				$plugin['baseUrl'] = $this->getAssetsUrl() . '/plugins/' . $id;
			}

			$this->_plugins[$id] = $plugin;
		}
	}

	/**
	 * @return array
	 */
	public function getPlugins()
	{
		return $this->_plugins;
	}
}
