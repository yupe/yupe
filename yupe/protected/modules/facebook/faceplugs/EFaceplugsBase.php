<?php

/**
 * Wrappers for facebook plugins.
 * @see http://www.yiiframework.com/extension/faceplugs/
 * 
 * @copyright © Digitick <www.digitick.net> 2011
 * @license GNU Lesser General Public License v3.0
 * @version 1.3
 * @author Ianaré Sévi
 * @author Gustavo Salomé
 */

/**
 * Base class for all facebook widgets.
 *
 * Initializes required properties for widgets and sets opengraph properties.
 *
 * @see http://developers.facebook.com/plugins
 * @see http://developers.facebook.com/docs/opengraph
 * 
 */
abstract class EFaceplugsBase extends CWidget
{
	/**
	 * Facebook application ID.
	 *
	 * This can be set in the 'fbAppId' parameter in the Yii config file.
	 * @var string
	 */
	public $app_id;
	/**
	 * Page URL, for Open Graph
	 * @var string
	 */
	public $url;
	public $css;
	/**
	 * Open Graph properties.
	 * @var array
	 */
	public $og = array();
	/**
	 * Check user's login status.
	 * @var boolean
	 */
	public $status = true;
	/**
	 * Enable cookies to allow the server to access the session.
	 * @var boolean
	 */
	public $cookie = true;
	/**
	 * Parse XFBML.
	 * @var boolean
	 */
	public $xfbml = true;
	/**
	 * Load the Facebook init script asynchronously.
	 *
	 * This speeds up page loads because loading the plugin does not block
	 * loading other elements of the page.
	 * @var boolean 
	 */
	public $async = true;
	/**
	 * Override default locale for the widget.
	 * 
	 * Normally locale is set automatically based on the Yii language settings,
	 * setting it here allows a specific locale to be used.
	 * @var string
	 */
	public $locale;
	/**
	 * Specify the debug mode. When active, it loads the debug version of
	 * the SDK (en_US only).
	 *
	 * Options :
	 * <ul>
	 * <li>'auto' - If YII_DEBUG is true, debug mode is active.
	 * <li>'on' - debug enabled.
	 * <li>'off' - debug disabled (default).
	 * </ul>
	 * @var string
	 */
	public $debugMode = 'off';
	/**
	 * URL of the script file to load.
	 * @var string
	 */
	protected $scriptFile = 'connect.facebook.net/%%locale%%/all.js';
	/**
	 * Allowed Open Graph properties.
	 * @var array
	 */
	protected $openGraphProperties = array(
		'admins',
		'app_id',
		'title',
		'type',
		'image',
		'url',
		'description',
		'site_name',
		'latitude',
		'longitude',
		'street-address',
		'locality',
		'region',
		'postal-code',
		'country-name',
		'email',
		'phone_number',
		'fax_number',
		'upc',
		'isbn',
		'video',
		'video:height',
		'video:width',
		'video:type',
		'audio',
		'audio:title',
		'audio:artist',
		'audio:album',
		'audio:type',
	);
	/**
	 * Valid Facebook locales.
	 * @var array
	 */
	protected $locales = array(
		'az_AZ',
		'be_BY',
		'bg_BG',
		'bn_IN',
		'bs_BA',
		'ca_ES',
		'ck_US',
		'cs_CZ',
		'cy_GB',
		'da_DK',
		'de_DE',
		'eu_ES',
		'en_GB',
		'en_PI',
		'en_UD',
		'en_US',
		'es_LA',
		'es_CL',
		'es_CO',
		'es_ES',
		'es_MX',
		'es_VE',
		'fb_FI',
		'fi_FI',
		'fr_FR',
		'gl_ES',
		'hu_HU',
		'it_IT',
		'ja_JP',
		'ko_KR',
		'nb_NO',
		'nn_NO',
		'nl_NL',
		'pl_PL',
		'pt_BR',
		'pt_PT',
		'ro_RO',
		'ru_RU',
		'sk_SK',
		'sl_SI',
		'sv_SE',
		'th_TH',
		'tr_TR',
		'ku_TR',
		'zh_CN',
		'zh_HK',
		'zh_TW',
		'fb_LT',
		'af_ZA',
		'sq_AL',
		'hy_AM',
		'hr_HR',
		'nl_BE',
		'eo_EO',
		'et_EE',
		'fo_FO',
		'fr_CA',
		'ka_GE',
		'el_GR',
		'gu_IN',
		'hi_IN',
		'is_IS',
		'id_ID',
		'ga_IE',
		'jv_ID',
		'kn_IN',
		'kk_KZ',
		'la_VA',
		'lv_LV',
		'li_NL',
		'lt_LT',
		'mk_MK',
		'mg_MG',
		'ms_MY',
		'mt_MT',
		'mr_IN',
		'mn_MN',
		'ne_NP',
		'pa_IN',
		'rm_CH',
		'sa_IN',
		'sr_RS',
		'so_SO',
		'sw_KE',
		'tl_PH',
		'ta_IN',
		'tt_RU',
		'te_IN',
		'ml_IN',
		'uk_UA',
		'uz_UZ',
		'vi_VN',
		'xh_ZA',
		'zu_ZA',
		'km_KH',
		'tg_TJ',
		'ar_AR',
		'he_IL',
		'ur_PK',
		'fa_IR',
		'sy_SY',
		'yi_DE',
		'gn_PY',
		'qu_PE',
		'ay_BO',
		'se_NO',
		'ps_AF',
		'tl_ST',
	);

	public function init()
	{
		if (property_exists($this, 'href') && $this->href === null) {
			$this->href = $this->url;
		}
		if (!$this->app_id && isset(Yii::app()->params->fbAppId)) {
			$this->app_id = Yii::app()->params->fbAppId;
		}
		if ($this->url) {
			$this->registerOpenGraph('url', $this->url);
		}
		if ($this->app_id) {
			$this->registerOpenGraph('app_id', $this->app_id);
		}

		foreach ($this->og as $type => $value) {
			$this->registerOpenGraph($type, $value);
		}
	}

	public function run()
	{
		//run only once
		if (!isset(Yii::app()->params->fbRootSet)) {
			if ($this->debugMode === 'auto' && YII_DEBUG === true) {
				$this->debugMode = 'on';
			}
			if ($this->debugMode === 'on') {
				$this->scriptFile = 'static.ak.fbcdn.net/connect/en_US/core.debug.js';
			}
			else {
				$this->setScriptLocale();
			}

			$protocol = 'http';
			if (isset($_SERVER['HTTPS'])) {
				$protocol .= 's';
			}
			$this->scriptFile = $protocol . '://' . $this->scriptFile;

			
			echo CHtml::openTag('div', array('id' => 'fb-root'));

			$init = $this->registerSDKScript('init', array(
				'status' => $this->status,
				'cookie' => $this->cookie,
				'xfbml' => $this->xfbml,
				'appId' => $this->app_id,
				)
			);

			if ($this->async) {
				$init = "window.fbAsyncInit = function(){{$init}};
				(function(){
				var e=document.createElement('script');
				e.async=true;
				e.src='{$this->scriptFile}';
				document.getElementById('fb-root').appendChild(e);}());";
			}
			else {
				Yii::app()->clientScript->registerScriptFile($this->scriptFile, CClientScript::POS_END);
			}
			Yii::app()->getClientScript()->registerScript('fb-script', $init, CClientScript::POS_END);
			echo CHtml::closeTag('div');

			Yii::app()->params->fbRootSet = true;
		}
	}

	/**
	 * Register an opengraph property.
	 * @param string $property
	 * @param string $data
	 */
	public function registerOpenGraph($property, $data)
	{
		if (!in_array($property, $this->openGraphProperties)) {
			throw new CException('Invalid open graph property : ' . $property);
		}
		$property = 'og:' . $property;
		Yii::app()->clientScript->registerMetaTag($data, null, null, array('property' => $property));
	}

	protected function setScriptLocale()
	{
		if (isset($this->locale)) {
			$locale = strtolower($this->locale);
		}
		else {
			$locale = Yii::app()->language;
		}
		// Adjustments, mainly because facebook doesn't have all countries
		// of the same language translated.
		$lang = substr($locale, 0, 2);
		$adjust = array(
			'de' => 'de_de',
			'nl' => 'nl_nl',
			'ru' => 'ru_ru',
			'ar' => 'ar_ar', // non standard
			'ku' => 'ku_tr',
		);
		// single check languages, array above ...
		if (isset($adjust[$lang])) {
			$locale = $adjust[$lang];
		}
		// english
		else if ($lang === 'en' && !in_array($locale, array('en_us','en_pi','en_ud'))) {
			// closer to US english
			if ($locale === 'en_ca') {
				$locale = 'en_us';
			}
			// closer to UK english
			else {
				$locale = 'en_gb';
			}
		}
		// french
		else if ($lang === 'fr' && $locale !== 'fr_ca') {
			$locale = 'fr_fr';
		}
		// spanish
		else if ($lang === 'es' && !in_array($locale, array('es_es','es_cl','es_co','es_mx','es_ve'))) {
			$locale = 'es_la'; // non standard
		}
		// portuguese
		else if ($lang === 'pt' && $locale !== 'pt_br') {
			$locale = 'pt_pt';
		}
		$c = explode('_', $locale);
		if (!isset($c[1])) {
			throw new CException('Locale for Facebook plugins must be in the following format : ll_CC');
		}
		$locale = $c[0] . '_' . strtoupper($c[1]);
		if (!in_array($locale, $this->locales)) {
			throw new CException('Invalid Facebook locale');
		}
		$this->scriptFile = str_replace('%%locale%%', $locale, $this->scriptFile);
	}

	/**
	 * Grabs public properties of the class for passing to the plugin creator.
	 * @return array Associative array
	 */
	protected function getParams()
	{
		$ignore = array('skin', 'actionPrefix', 'app_id', 'url', 'status',
			'cookie', 'async', 'debugMode', 'xfbml');
		$ref = new ReflectionObject($this);
		$props = $ref->getProperties(ReflectionProperty::IS_PUBLIC);

		$params = array();
		foreach ($props as $k => $v) {
			$name = $v->name;
			if ($this->$name !== null && !is_array($this->$name) && !in_array($name, $ignore)) {
				if (is_bool($this->$name)) {
					$value = ($this->$name === true) ? 'true' : 'false';
				}
				else {
					$value = $this->$name;
				}
				$params[$name] = $value;
			}
		}
		return $params;
	}

	/**
	 * creates a method of facebook sdk script
	 *
	 * @param string $method
	 * @param array $args args to use in the method
	 * @return string the js created
	 */
	public function registerSDKScript($method, $args=array())
	{
		$args = CJavaScript::encode($args);
		return "FB.{$method}({$args});";
	}

}
