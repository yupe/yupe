<?php
/**
 * Wrappers for facebook plugins.
 * @copyright © Digitick <www.digitick.net> 2011
 * @license GNU Lesser General Public License v3.0
 * @author Ianaré Sévi
 */

require_once 'EFaceplugsBase.php';

/**
 * The Like button lets a user share your content with friends on Facebook.
 *
 * When the user clicks the Like button on your site, a story appears in the
 * user's friends' News Feed with a link back to your website.
 *
 * @see http://developers.facebook.com/docs/reference/plugins/like
 */
class LikeButton extends EFaceplugsBase
{
    /**
     * The URL of the Facebook page for this Like button.
     * @var string
     */
    public $href;
    /**
     * Display profile photos below the button (standard layout only)
     * @var boolean
     */
    public $show_faces;
    /**
     * Width of the Like button, defults to 450px
     * @var integer
     */
    public $width;
    /**
     * Three options : 'standard', 'button_count', 'box_count'
     * @var string
     */
    public $layout;
    /**
     * The verb to display on the button. Options: 'like', 'recommend'
     * @var string
     */
    public $action;
    /**
     * The font to display in the button. Options: 'arial', 'lucida grande',
     * 'segoe ui', 'tahoma', 'trebuchet ms', 'verdana'
     * @var string
     */
    public $font;
    /**
     * The color scheme for the plugin. Options: 'light', 'dark'
     * @var string
     */
    public $colorscheme;
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
        echo CHtml::openTag('fb:like', $params), CHtml::closeTag('fb:like');
    }
}
