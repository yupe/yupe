<?php
/**
 * Wrappers for facebook plugins.
 * @copyright © Digitick <www.digitick.net> 2011
 * @license GNU Lesser General Public License v3.0
 * @author Ianaré Sévi
 */

require_once 'EFaceplugsBase.php';

/**
 * The Like Box is a social plugin that enables Facebook Page owners to
 * attract and gain Likes from their own website.
 *
 * The Like Box enables users to:
 * <ul>
 * <li>See how many users already like this page, and which of their friends like it too
 * <li>Read recent posts from the page
 * <li>Like the page with one click, without needing to visit the page
 * </ul>
 *
 * @see http://developers.facebook.com/docs/reference/plugins/like
 */
class LikeBox extends EFaceplugsBase
{
    /**
     * The URL of the Facebook page for this Like Box.
     * @var string
     */
    public $href;
    /**
     * Display profile photos in the plugin.
     * @var boolean
     */
    public $show_faces;
    /**
     * The width of the plugin in pixels. Default width: 300px.
     * @var integer
     */
    public $width;
    /**
     * The height of the plugin in pixels.
     * @var integer
     */
    public $height;
    /**
     * Specifies whether to display a stream of the latest posts from the
     * page's wall.
     * @var boolean
     */
    public $stream;
    /**
     * Specifies whether to display the Facebook header at the top of the plugin.
     * @var boolean
     */
    public $header;
    /**
     * The color scheme for the plugin. Options: 'light', 'dark'
     * @var string
     */
    public $colorscheme;
    /**
     * Specifies the profile to like.
     * @var string
     */
    public $profile_id;

    public function run()
    {
        parent::run();

        if (!isset($this->profile_id))
        {
            $this->profile_id = $this->app_id;
        }
        $params = $this->getParams();
        echo CHtml::openTag('fb:like-box', $params), CHtml::closeTag('fb:like-box');
    }
}
