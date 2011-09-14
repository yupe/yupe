<?php
/**
 * Wrappers for facebook plugins.
 * @copyright © Digitick <www.digitick.net> 2011
 * @license GNU Lesser General Public License v3.0
 * @author Ianaré Sévi
 */

require_once 'EFaceplugsBase.php';

/**
 * The Comments Box easily enables your users to comment on your site's content —
 * whether it's for a web page, article, photo, or other piece of content.
 *
 * @see http://developers.facebook.com/docs/reference/plugins/comments
 */
class Comments extends EFaceplugsBase
{
    /**
     * Number of posts to show.
     * @var integer
     */
    public $numposts;
    /**
     * the width of the widget.
     * @var integer
     */
    public $width;
    /**
     * Specify whether to publish a comment on the user's wall.
     * @var boolean
     */
    public $publish_feed = true;

    public function run()
    {
        parent::run();

        $params = $this->getParams();
        echo CHtml::openTag('fb:comments', $params), CHtml::closeTag('fb:comments');
    }

}
