<?php
/**
 * Class YTheme
 *
 * Adds to standard CTheme class:
 *
 *  -   Ability to retrieve additional information related to theme from JSON file "metaData.json" that comes with theme.
 *      This information internally called as "metadata", one can see the list of its available
 *      entries and their default values at {@link getDefaultMetadata()}.
 *      Metadata containing file is optional, if it doesn't exists default metadata values will be used. Every
 *      available metadata option is also optional - defaults will be used instead of missing pairs of keys and values.
 *
 *  -   Support of theme regions for content to be rendered into.
 *      One may add any content to region via {@link addContentToRegion()} method. Content will NOT be changed
 *      in any way before rendering (i.e. it will not be html-encoded, etc.).
 *      Regions shall be rendered at theme layout files using {@link region()} method, for example:
 *      <pre>
 *      <div class="sidebar">
 *          <?php echo Yii::app()->theme->region("sidebar"); ?>
 *      </div>
 *      </pre>
 *      Also you may want to check whether region does not contain any content - use {@link regionEmpty()} method.
 *      List of available regions must be specified at metadata option called "regions":
 *      <pre>
 *      {
 *      ...
 *      "regions": {
 *          "header": "Description of header region",
 *          ...
 *      },
 *      ...
 *      }
 *      </pre>
 *      List of all theme's regions can be fetched via {@link getRegions()} method.
 *
 *  -   Theme inheritance. If "parentTheme" parameter is specified at metadata, its value will be used as parent theme name.
 *      Child theme inherits all of parent views, layouts and public files.
 *      Moreover, nesting depth is not limited - parent theme can also have its parent, i.e. potential family tree can look like:
 *      - Default theme
 *          - First default sub-theme
 *          - Second default sub-theme
 *              - Third default sub-theme
 *
 *  -   Resources are theme files, accessible via web. They are intended to be stored at relative to theme root
 *      directory, which name is defined as value of "resourcesDir" metadata parameter, that defaults to "web".
 *      When theme is being initialized, the contents of this directory are published via {@link CAssetManager},
 *      so you can easily hide your themes to directory inaccessible from web. However, this approach requires the use
 *      of a {@link resource()} method that returns the URL of requested file instead of appending file path to
 *      result of {@link getBaseUrl()} method as you used to do. Here is an example of how to do in in a right way:
 *      <pre>
 *      <link rel="stylesheet" type="text/css" href="<?= Yii::app()->theme->resource('css/screen.css'); ?>"
 *      </pre>
 *
 *  -   An events. Now {@link onThemeInit()} and {@link onContentAddedToRegion()} are available.
 *
 *  -   Ability to determine whether theme is designed for applications's backend or frontend.
 *      Theme directory name beginning from "backend_" means theme is designed for backend section of application.
 *      You can check this out by using {@link getIsBackend()} and {@link getIsFrontend} methods.
 *
 * @author Alexander Bolshakov <a.bolshakov.coder@gmail.com>
 */
class YTheme extends CTheme
{
    const METADATA_FILENAME = 'metaData.json';


    protected $_title;
    protected $_description;
    protected $_authors;
    protected $_version;
    protected $_screenshot;
    /**
     * @var YTheme|null
     */
    protected $_parentTheme;
    protected $_cssFiles = array();
    protected $_regions = array();
    protected $_resourcesDir;
    protected $_isBackend;

    /**
     * @var array Content of regions in a way: region name => region content
     */
    protected $_regionsContent = array();

    protected $_resourcesUrl;

    /**
     * @return string Theme's title.
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * @return string Theme's authors.
     */
    public function getAuthors()
    {
        return $this->_authors;
    }

    /**
     * @return YTheme|null Instance of parent theme if it exists. Null otherwise.
     */
    public function getParentTheme()
    {
        return $this->_parentTheme;
    }

    /**
     * @return string|null Screenshot filepath relative to theme resources path.
     * Checks for parent theme screenshot if current theme doesn't have it.
     */
    public function getScreenshot()
    {
        if ($this->_screenshot == null && $this->_parentTheme instanceof YTheme) {
            return $this->_parentTheme->getScreenshot();
        }

        return $this->_screenshot;
    }

    /**
     * @return string Theme's version.
     */
    public function getVersion()
    {
        return $this->_version;
    }

    /**
     * @return string Theme's description.
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
     * @return array Theme regions in format: Region ID => Region description
     */
    public function getRegions()
    {
        return $this->_regions;
    }

    /**
     * Adds any content to specified region.
     *
     * @param string $regionName
     * @param string $content
     */
    public function addContentToRegion($regionName, $content)
    {
        $this->checkRegionExists($regionName, 'Невозможно добавить контент в несуществующий регион "{region}".');
        if (isset($this->_regionsContent[$regionName])) {
            $this->_regionsContent[$regionName] .= $content;
        } else {
            $this->_regionsContent[$regionName] = $content;
        }
        $this->onContentAddedToRegion(new CEvent($this, array('region' => $regionName)));
    }

    /**
     * Returns contents of specified region.
     * This method is intended for using at theme layouts.
     *
     * @param $regionName
     *
     * @return string|null
     */
    public function region($regionName)
    {
        $this->checkRegionExists($regionName);
        if (isset($this->_regionsContent[$regionName])) {
            return $this->_regionsContent[$regionName];
        } else {
            return null;
        }
    }

    /**
     * This method is intended for using at theme layouts.
     *
     * @param $regionName
     *
     * @return bool Whether specified region does not contain any content.
     */
    public function regionEmpty($regionName)
    {
        $this->checkRegionExists($regionName);
        if (isset($this->_regionsContent[$regionName]) && !empty($this->_regionsContent[$regionName])) {
            return false;
        }

        return true;
    }

    /**
     * Checks whether specified region exists.
     *
     * @param             $regionName
     * @param string|null $errorMessage Message shown on error. You may use "{region}" placeholder.
     *
     * @throws InvalidArgumentException If region does not exists.
     */
    public function checkRegionExists($regionName, $errorMessage = null)
    {
        $errorMessage = ($errorMessage == null) ? 'Регион "{region}" не существует.' : $errorMessage;
        if (!isset($this->_regions[$regionName])) {
            throw new InvalidArgumentException(Yii::t(
                'AppearanceModule.messages',
                $errorMessage,
                array('{region}' => $regionName)
            ));
        }
    }

    /**
     * @return bool Whether theme is enabled for its environment - backend or frontend.
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
     * Returns absolute URL for file that can be accessed from web. Checks for parent theme if file does not exists.
     *
     * @param string $pathToResourceFile Path to file, relative from theme resource directory.
     *
     * @return null|string URL of file. Null if file exists neither at current theme dir, nor at parent theme dir.
     */
    public function resource($pathToResourceFile)
    {
        $pathToResourceFile = str_replace(
            array('..', '/', '\\'),
            array('', DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR),
            trim($pathToResourceFile, '/\\')
        );
        return $this->resolveResourceUrl($pathToResourceFile);
    }

    /**
     * Internally used method. Resolves where from to take resource file - at current theme resource directory
     * or at its parent theme resources dir. Mainly exists because there is no need to filter path to resource
     * file at {@link resource()} again when calling parent theme method.
     *
     * @param $pathToResourceFile
     *
     * @return null|string
     */
    public function resolveResourceUrl($pathToResourceFile)
    {
        $fullPathToFile = $this->getBasePath()
            . DIRECTORY_SEPARATOR . $this->_resourcesDir
            . DIRECTORY_SEPARATOR . $pathToResourceFile;
        if (file_exists($fullPathToFile)) {
            $urlOfResourceFile = str_replace(array('/', '\\'), '/', $pathToResourceFile);
            $fullUrlOfFile     = $this->_resourcesUrl . '/' . $urlOfResourceFile;
            return $fullUrlOfFile;
        } elseif ($this->_parentTheme instanceof YTheme) {
            return $this->_parentTheme->resolveResourceUrl($pathToResourceFile);
        } else {
            return null;
        }
    }

    /**
     * An event which is being risen right after theme initialization.
     *
     * @param CEvent $event
     *
     * @return void
     */
    public function onThemeInit(CEvent $event)
    {
        $this->raiseEvent('onThemeInit', $event);
    }

    /**
     * An event which raises when content was added to region. Region name is available as event parameter "region".
     *
     * @param CEvent $event
     *
     * @return void
     */
    public function onContentAddedToRegion(CEvent $event)
    {
        $this->raiseEvent('onContentAddedToRegion', $event);
    }

    /** Internally used methods are under this line.  */

    /**
     * Constructor.
     *
     * @param string $name     Name of the theme
     * @param string $basePath Base theme path
     * @param string $baseUrl  Base theme URL
     */
    public function __construct($name, $basePath, $baseUrl)
    {
        parent::__construct($name, $basePath, $baseUrl);
        $this->init();
    }

    /**
     * Initializes theme and raises "onThemeInit" event. Called at the end of constructor.
     *
     * @return void
     */
    protected function init()
    {
        $this->loadMetadata();
        $this->registerResources();
        $this->onThemeInit(new CEvent($this));
    }

    /**
     * Publishes theme resource directory via asset manager.
     *
     * @return void
     */
    protected function registerResources()
    {
        $resourcesDir = $this->getBasePath() . DIRECTORY_SEPARATOR . $this->_resourcesDir;
        if (is_dir($resourcesDir)) {
            $this->_resourcesUrl = Yii::app()->assetManager->publish($resourcesDir);
        }
    }

    /**
     * Loads theme metadata from its file. If it does not exists, default values are used.
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
        $this->_screenshot  = (string)$metaData['screenshot'];
        $this->_cssFiles    = (array)$metaData['cssFiles'];
        $this->_regions     = (array)$metaData['regions'];
        $this->setResourcesDir((string)$metaData['resourcesDir']);
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

    /**
     * @return array Default values for theme metadata entries.
     */
    protected function getDefaultMetadata()
    {
        return array(
            'title'        => null,
            'description'  => null,
            'version'      => null,
            'authors'      => null,
            'screenshot'   => null,
            'cssFiles'     => array(),
            'regions'      => array(),
            'parentTheme'  => null,
            'resourcesDir' => 'web',
        );
    }

    /**
     * @param string $resourcesDir Name of directory under theme root that contain resources.
     *
     * @return void
     */
    protected function setResourcesDir($resourcesDir)
    {
        $this->_resourcesDir = str_replace(array('..', '/', '\\'), '', $resourcesDir);
    }

    /**
     * Sets parent theme based on its name.
     *
     * @param string $themeName The name of estimated parent theme.
     *
     * @return void
     */
    protected function setParentTheme($themeName)
    {
        /** @var $tm CThemeManager */
        $tm = Yii::app()->themeManager;

        if ($themeName != null && (($theme = $tm->getTheme((string)$themeName)) instanceof YTheme)) {
            $this->_parentTheme = $theme;
        }
    }

    /**
     * Finds the view file for the specified widget's view. If widget belongs to any module, view file will be
     * searched under "{themeRootPath}/{themeViewPath}/{moduleID}/widgets/{WidgetClassName}". Otherwise, view file
     * will be searched under "{themeRootPath}/{themeViewPath}/{WidgetClassName}".
     *
     * Also, this method searches under parent theme directories if view file was not found for current theme.
     *
     * @param YWidget $widget   Instance of widget
     * @param string  $viewName View name
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