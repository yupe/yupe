<?php
/**
 * Wrappers for facebook plugins.
 * @copyright © Digitick <www.digitick.net> 2011
 * @license GNU Lesser General Public License v3.0
 * @author Ianaré Sévi
 */

require_once 'EFaceplugsBase.php';

/**
 * The Facepile plugin displays the Facebook profile pictures of users who
 * have liked your page or have signed up for your site.
 *
 * @see http://developers.facebook.com/docs/reference/plugins/facepile/
 */
class Facepile extends EFaceplugsBase
{
	/**
	 * The URL of the page.
	 *
	 * The plugin will display photos of users who have liked this page.
	 * @var string
	 */
	public $href;
	/**
	 * The maximum number of rows of faces to display.
	 *
	 * Height is dynamically sized; if you specify a maximum of four rows of
	 * faces, but there are only enough friends to fill two rows, the plugin
	 * will set its height for two rows of faces. Default: 1.
	 * @var integer
	 */
	public $max_rows;
	/**
	 * Width of the plugin in pixels. Default width: 200px.
	 * @var integer
	 */
	public $width;

	public function run()
	{
		parent::run();

		$params = $this->getParams();
		echo CHtml::openTag('fb:facepile', $params), CHtml::closeTag('fb:facepile');
	}

}
