<?php
/**
 * Class YTheme
 *
 * @author Alexander Bolshakov <a.bolshakov.coder@gmail.com>
 */
class YTheme extends CTheme
{
    const METADATA_FILENAME = 'metaData.json';
    const FRONTEND          = 1;
    const BACKEND           = 0;

    /**
     * @var string
     */
    protected $_title;

    /**
     * @var string
     */
    protected $_description;

    /**
     * @var string
     */
    protected $_authors;

    /**
     * @var string
     */
    protected $_version;

    /**
     * @var array
     */
    protected $_screenshots = array();

    /**
     * @var YTheme
     */
    protected $_parentTheme;

    /**
     * @var array
     */
    protected $_cssFiles = array();

    /**
     * @var bool
     */
    protected $_isBackend;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * @return string
     */
    public function getAuthors()
    {
        return $this->_authors;
    }

    /**
     * @return YTheme|null
     */
    public function getParentTheme()
    {
        return $this->_parentTheme;
    }

    /**
     * @return array List of screenshots' filepaths.
     * Checks for parent theme screenshots if current theme doesn't have them.
     */
    public function getScreenshots()
    {
        if (empty($this->_screenshots) && $this->_parentTheme instanceof YTheme) {
            return $this->_parentTheme->getScreenshots();
        }

        return $this->_screenshots;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->_version;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * @return array
     */
    public function getCssFiles()
    {
        return $this->_cssFiles;
    }


    /**
     * @return bool Whether theme is enabled for it's environment - backend or frontend.
     */
    public function getIsEnabled()
    {
        return AppearanceModule::get()->getIsThemeEnabled($this);
    }

    /**
     * @return bool Whether theme is designed for backend.
     */
    public function getIsBackend()
    {
        if ($this->_isBackend == null) {
            $this->_isBackend = (strpos($this->getName(), 'backend_') === 0);
        }

        return $this->_isBackend;
    }

    /**
     * @return bool Whether theme is designed for frontend.
     */
    public function getIsFrontend()
    {
        return !$this->getIsBackend();
    }

    /**
     * Returns absolute URL for file that can be accessed from web. Checks for parent theme if file does not exist.
     *
     * @param string $path Path to file, relative from theme root directory.
     *
     * @return null|string URL of file or null if it does not exist.
     */
    public function getPublicFile($path)
    {
        $fullPath = realpath($this->getBasePath() . $path);
        if (file_exists($fullPath)) {
            return $this->baseUrl . $path;
        } elseif ($this->_parentTheme instanceof YTheme) {
            return $this->_parentTheme->getPublicFile($path);
        } else {
            Yii::log(
                'Required by theme asset-file "' . $path . '" is found neither at theme directory, nor at parent theme directory.',
                CLogger::LEVEL_ERROR
            );

            return null;
        }
    }

    public function __construct($name, $basePath, $baseUrl)
    {
        parent::__construct($name, $basePath, $baseUrl);
        $this->init();
    }

    protected function init()
    {
        $this->loadMetadata();
    }

    /**
     * Loads theme metadata from it's file. If it does not exists, default values are used.
     * Moreover, if file does not contains some entries, their default values are used.
     * Also filters metadata entries, correct names of them are listed at {@link getDefaultMetadata()}
     *
     * @see getDefaultMetadata()
     * @return void
     */
    protected function loadMetadata()
    {
        $metaData = $this->readMetadataFromFile();
        $metaData = array_merge($this->getDefaultMetadata(), $metaData);
        $metaData = array_intersect_key($metaData, array_flip(array_keys($this->getDefaultMetadata())));

        $this->_title       = (string)$metaData['title'];
        $this->_description = (string)$metaData['description'];
        $this->_authors     = (string)$metaData['authors'];
        $this->_version     = (string)$metaData['version'];
        $this->_screenshots = (array)$metaData['screenshots'];
        $this->_cssFiles    = (array)$metaData['cssFiles'];
        $this->setParentTheme($metaData['parentTheme']);
    }

    /**
     * @return array Metadata loaded from file or empty array if it does not exists.
     */
    protected function readMetadataFromFile()
    {
        $filePath = $this->getBasePath() . DIRECTORY_SEPARATOR . self::METADATA_FILENAME;
        $filePath = realpath($filePath);
        if (is_readable($filePath) && is_file($filePath)) {
            $rawFileContent = file_get_contents($filePath);
            $metaData       = json_decode($rawFileContent, true);
        } else {
            $metaData = array();
        }

        return $metaData;
    }

    protected function getDefaultMetadata()
    {
        return array(
            'title'       => null,
            'description' => null,
            'version'     => null,
            'authors'     => null,
            'screenshots' => array(),
            'cssFiles'    => array(),
            'parentTheme' => null,
        );
    }

    protected function setParentTheme($themeName)
    {
        /** @var $tm CThemeManager */
        $tm = Yii::app()->themeManager;

        if ($themeName != null && (($theme = $tm->getTheme((string)$themeName)) instanceof YTheme)) {
            $this->_parentTheme = $theme;
        }
    }

    /**
     * Tries to find widget's view file based on its name.
     * If widget belongs to any module, widget view files will be searched under "themeRoot/themeViews/moduleID/widgets/WidgetClass"
     * Otherwise, widget view files will be searched under "themeRoot/themeViews/WidgetClass".
     *
     * Also, this method searches under parent theme directories.
     *
     * @param YWidget    $widget   Instance of widget
     * @param     string $viewName View name
     *
     * @return string|bool Path to view file or false if it wasn't found.
     */
    public function getWidgetViewFile(YWidget $widget, $viewName)
    {
        $widgetClass = get_class($widget);
        if (($moduleID = $widget->getModuleID()) !== null) {
            $viewPath =
                $this->getViewPath()
                    . DIRECTORY_SEPARATOR . $moduleID
                    . DIRECTORY_SEPARATOR . 'widgets'
                    . DIRECTORY_SEPARATOR . $widgetClass;
        } else {
            $viewPath = $this->getViewPath() . DIRECTORY_SEPARATOR . $widgetClass;
        }
        $viewFile = Yii::app()->getController()->resolveViewFile($viewName, $viewPath, $viewPath, $viewPath);

        if ($viewFile === false && $this->_parentTheme instanceof YTheme) {
            return $this->_parentTheme->getWidgetViewFile($widget, $viewName);
        }

        return $viewFile;
    }

    public function getViewPath()
    {
        $viewPath = parent::getViewPath();
        if (!is_dir($viewPath) && $this->_parentTheme instanceof YTheme) {
            return $this->_parentTheme->getViewPath();
        } else {
            return $viewPath;
        }
    }

    public function getViewFile($controller, $viewName)
    {
        $viewFile = parent::getViewFile($controller, $viewName);

        if ($viewFile === false && $this->_parentTheme instanceof YTheme) {
            return $this->_parentTheme->getViewFile($controller, $viewName);
        } else {
            return $viewFile;
        }
    }

    public function getLayoutFile($controller, $layoutName)
    {
        $layoutFile = parent::getLayoutFile($controller, $layoutName);
        if ($layoutFile === false && $this->_parentTheme instanceof YTheme) {
            return $this->_parentTheme->getLayoutFile($controller, $layoutName);
        } else {
            return $layoutFile;
        }
    }


}