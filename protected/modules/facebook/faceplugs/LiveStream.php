<?php
/**
 * Wrappers for facebook plugins.
 * @copyright © Digitick <www.digitick.net> 2011
 * @license GNU Lesser General Public License v3.0
 * @author Ianaré Sévi
 */

require_once 'EFaceplugsAppLink.php';

/**
 * The Live Stream plugin lets your users share activity and comments in
 * real-time as they interact during a live event.
 *
 * @see http://developers.facebook.com/docs/reference/plugins/live-stream
 */
class LiveStream extends EFaceplugsAppLink
{
	/**
	 * Width of the plugin in pixels. Default width: 400px.
	 * @var integer
	 */
	public $width;
	/**
	 * The height of the plugin in pixels. Default height: 500px.
	 * @var integer
	 */
	public $height;
	/**
	 * The URL that users are redirected to when they click on your app name on
	 * a status (if not specified, your Connect URL is used).
	 * @var string
	 */
	public $via_url;
	/**
	 * If you have multiple live stream boxes on the same page, specify a
	 * unique xid for each.
	 * @var integer
	 */
	public $xid;

	public function run()
	{
		parent::run();

		$params = $this->getParams();
		echo CHtml::openTag('fb:live-stream', $params), CHtml::closeTag('fb:live-stream');
	}

}