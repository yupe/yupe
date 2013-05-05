<?php
/**
 * YiiDebugToolbar class file.
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 */

Yii::import('yii-debug-toolbar.panels.*');
Yii::import('yii-debug-toolbar.widgets.*');

/**
 * YiiDebugToolbar represents an ...
 *
 * Description of YiiDebugToolbar
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 * @author Igor Golovanov <igor.golovanov@gmail.com>
 * @version $Id$
 * @package YiiDebugToolbar
 * @since 1.1.7
 */
class YiiDebugToolbar extends CWidget
{
    /**
     * CSS File.
     *
     * @var string
     */
    public $cssFile;

    /**
     * The URL of assets.
     *
     * @var string
     */
    private $_assetsUrl;

    /**
     * Panels.
     *
     * @var array
     */
    private $_panels;
    
    /**
     * Adds a panel to the top of the stack
     * @param string $panel Name class panel
     */
    public function prependPanel($panel){
        array_unshift($this->_panels, $panel);
    }
    
    /**
     * Adds a panel at the end of the stack
     * @param string $panel Name class panel
     */
    public function appendPanel($panel){
        array_push($this->_panels, $panel);
    }

    /**
     * Setup toolbar panels.
     *
     * @param array $panels Panels.
     * @return YiiDebugToolbar
     */
    public function setPanels(array $panels = array())
    {
        $this->_panels = $panels;
        return $this;
    }

    /**
     * Get toolbar panels.
     *
     * @return array
     */
    public function getPanels()
    {
        if(null === $this->_panels)
        {
            $this->_panels = array();
        }
        return $this->_panels;
    }

    /**
     * Get the URL of assets.
     * The base URL that contains all published asset files of yii-debug-toolbar.
     * @return string
     */
    public function getAssetsUrl()
    {
        if (null === $this->_assetsUrl && 'cli' !== php_sapi_name())
            $this->_assetsUrl = Yii::app()
                ->getAssetManager()
                ->publish(dirname(__FILE__) . '/assets', false, -1, YII_DEBUG);
        return $this->_assetsUrl;
    }

    public function getLogs()
    {
        return $this->owner->logs;
    }

    /**
     * Set the URL of assets.
     * The base URL that contains all published asset files of yii-debug-toolbar.
     *
     * @param string $value
     */
    public function setAssetsUrl($value)
    {
        $this->_assetsUrl = $value;
    }

    /**
     * Initialization.
     */
    public function init()
    {
        if (false === ($this->owner instanceof CLogRoute))
        {
            throw new CException(YiiDebug::t('YiiDebugToolbar owner must be instance of CLogRoute'));
        }

        $this->createPanels()
             ->registerClientScripts();
    }

    /**
     * Run.
     */
    public function run()
    {
        $content = '';

        try {
            $content .= $this->render('yii_debug_toolbar', array(
                'panels' => $this->getPanels()
            ), true);
        }
        catch (Exception $e)
        {
            throw new CException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }

        echo $content;
    }

    /**
     * Register client scripts.
     *
     * @return YiiDebugToolbar
     */
    private function registerClientScripts()
    {
        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        $cs->registerCoreScript('cookie');

        if (false !== $this->cssFile)
        {
            if (null === $this->cssFile)
                $this->cssFile = $this->assetsUrl . '/style.css';
            $cs->registerCssFile($this->cssFile);
        }

        $cs->registerScriptFile($this->assetsUrl . '/yii.debug.toolbar.js',
                CClientScript::POS_END);

        return $this;
    }

    /**
     * Create panels.
     *
     * @return YiiDebugToolbar
     */
    private function createPanels()
    {
        foreach ($this->getPanels() as $id => $config)
        {
            if (!is_object($config))
            {
                
                if (isset($config['enabled']) && false === $config['enabled'])
                {
                    unset($this->_panels[$id]);
                    continue;
                }
                else if (isset($config['enabled']) && true === $config['enabled'])
                {
                    unset($config['enabled']);
                }

                $panel = Yii::createComponent($config, $this);

                if (false === ($panel instanceof YiiDebugToolbarPanelInterface))
                {
                    throw new CException(Yii::t('yii-debug-toolbar',
                            'The %class% class must be compatible with YiiDebugToolbarPanelInterface', array(
                                '%class%' => get_class($panel)
                            )));
                }
                $panel->init();
                $this->_panels[$id] = $panel;
            }
        }
        return $this;
    }
}

/**
 * YiiDebugToolbarPanelInterface
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 * @author Igor Golovanov <igor.golovanov@gmail.com>
 * @version $Id$
 * @package YiiDebugToolbar
 * @since 1.1.7
 */
interface YiiDebugToolbarPanelInterface
{
    /**
     * Get the title of menu.
     *
     * @return string
     */
    function getMenuTitle();

    /**
     * Get the subtitle of menu.
     *
     * @return string
     */
    function getMenuSubTitle();

    /**
     * Get the title.
     *
     * @return string
     */
    function getTitle();

    /**
     * Get the subtitle.
     *
     * @return string
     */
    function getSubTitle();
}
