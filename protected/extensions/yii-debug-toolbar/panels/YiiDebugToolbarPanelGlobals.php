<?php
/**
 * YiiDebugToolbarPanelGlobals class file.
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 */


/**
 * YiiDebugToolbarPanelGlobals class
 *
 * Description of YiiDebugToolbarPanelGlobals
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 * @author Igor Golovanov <igor.golovanov@gmail.com>
 * @version $Id$
 * @package YiiDebugToolbar
 * @since 1.1.7
 */
class YiiDebugToolbarPanelGlobals extends YiiDebugToolbarPanel
{
    /**
     * {@inheritdoc}
     */
    public function getMenuTitle()
    {
        return YiiDebug::t('Globals');
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return YiiDebug::t('Global Variables');
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {}

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->render('globals', array(
            'server' => $_SERVER,
            'cookies' => $_COOKIE,
            'session' => isset($_SESSION) ? $_SESSION : null,
            'post' => $_POST,
            'get' => $_GET,
            'files' => $_FILES,
        ));
    }
}
