<?php
/**
 * Wrappers for facebook plugins.
 * @copyright © Digitick <www.digitick.net> 2011
 * @license GNU Lesser General Public License v3.0
 * @author Ianaré Sévi
 */

require_once 'EFaceplugsBase.php';

/**
 * The Recommendations plugin shows personalized recommendations to your users.
 *
 * @see http://developers.facebook.com/docs/reference/plugins/recommendations
 */
class Recommendations extends EFaceplugsBase
{
	/**
	 * The domain to show activity for. Defaults to the current domain.
	 * @var string
	 */
	public $site;
	/**
	 * The height of the plugin in pixels. Default height: 300px.
	 * @var integer
	 */
	public $height;
	/**
	 * the width of the plugin in pixels. Default width: 300px.
	 * @var integer
	 */
	public $width;
	/**
	 * Specifies whether to show the Facebook header. 
	 * @var boolean
	 */
	public $header;
	/**
	 * The color scheme for the plugin. Options: 'light', 'dark'
	 * @var string
	 */
	public $colorscheme;
	/**
	 * The font to display in the plugin. Options: 'arial', 'lucida grande',
	 * 'segoe ui', 'tahoma', 'trebuchet ms', 'verdana'
	 * @var string
	 */
	public $font;
	/**
	 * The border color of the plugin.
	 * @var string
	 */
	public $border_color;
	/**
	 * Allows you to filter which URLs are shown in the plugin.
	 *
	 * The plugin will only include URLs which contain the filter in the first
	 * two path parameters of the URL. If nothing in the first two path
	 * parameters of the URL matches the filter, the URL will not be included.
	 * @var string
	 */
	public $filter;
	/**
	 * A label for tracking referrals; must be less than 50 characters and can
	 * contain alphanumeric characters and some punctuation (currently +/=-.:_).
	 * @var string
	 */
	public $ref;

	public function run()
	{
		parent::run();

		$params = $this->getParams();
		echo CHtml::openTag('fb:recommendations', $params), CHtml::closeTag('fb:recommendations');
	}

}
