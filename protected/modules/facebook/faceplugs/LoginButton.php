<?php

/**
 * Wrappers for facebook plugins.
 * @copyright © Digitick <www.digitick.net> 2011
 * @license GNU Lesser General Public License v3.0
 * @author Ianaré Sévi
 */

require_once 'EFaceplugsAppLink.php';

/**
 * The Login Button shows profile pictures of the user's friends who have
 * already signed up for your site in addition to a login button.
 *
 * @see http://developers.facebook.com/docs/reference/plugins/login
 */
class LoginButton extends EFaceplugsAppLink
{
    /**
     * The URL of the page.
     *
     * The plugin will display photos of users who have liked this page.
     * @var string
     */
    public $show_faces;
    /**
     * The maximum number of rows of profile pictures to display.
     * Default value: 1.
     * @var integer
     */
    public $max_rows;
    /**
     * The width of the plugin in pixels. Default width: 200px.
     * @var integer
     */
    public $width;
    /**
     * A comma separated list of extended permissions.
     *
     * By default the Login button prompts users for their public information.
     * If your application needs to access other parts of the user's profile
     * that may be private, your application can request extended permissions.
     *
     * @see http://developers.facebook.com/docs/authentication/permissions/
     * @var string
     */
    public $perms;

    public function run()
    {
        parent::run();

        $params = $this->getParams();
        echo CHtml::openTag('fb:login-button', $params), CHtml::closeTag('fb:login-button');
    }

}
