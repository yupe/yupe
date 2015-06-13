<?php
namespace application\modules\update\components;

use Yii;
use CException;
use CApplicationComponent;
use GuzzleHttp\Client;
use yupe\helpers\YFile;


/**
 * Class UpdateManager
 * @package application\modules\update\components
 */
class UpdateManager extends CApplicationComponent
{
    /**
     *
     */
    const DEFAULT_VERSION_LABEL = '---';

    /**
     *
     */
    const LOG_CATEGORY = 'update-center';

    /**
     * @var string
     */
    protected $checkUpdateUrl = 'http://yupe.ru/marketplace/check';

    /**
     * @var string
     */
    protected $getModuleUrl = 'http://promo.local/marketplace/module';

    // 8 часов
    /**
     * @var int
     */
    public $cacheTime = 43200;

    /**
     * @var
     */
    protected $client;

    /**
     * @var
     */
    protected $module;

    /**
     * @var string
     */
    protected $moduleFileExtension = 'zip';

    /**
     * @var
     */
    protected $moduleManager;

    /**
     * @var
     */
    protected $cache;

    /**
     * @var
     */
    protected $migrator;

    /**
     * @throws \CException
     */
    public function init()
    {
        parent::init();

        if (!$this->checkUpdateUrl) {
            throw new CException("Unknown checkUpdateUrl...");
        }

        $this->client = new Client;

        $this->module = Yii::app()->getModule('update');

        $this->moduleManager = Yii::app()->moduleManager;

        $this->cache = Yii::app()->getCache();

        $this->migrator = Yii::app()->migrator;
    }

    /**
     * @return bool
     */
    public function getModulesUpdateInfo(array $modules)
    {

        try {

            $data = false;//Yii::app()->getCache()->get('yupe::update::info');

            if (false === $data) {

                $check = [];

                Yii::log('Start get updates from server...', \CLogger::LEVEL_INFO, static::LOG_CATEGORY);

                foreach ($modules as $id => $module) {
                    $check[$module->getId()] = $module->getVersion();
                }

                $data = $this->client->get(
                    $this->checkUpdateUrl,
                    [
                        'query' => [
                            'data' => \CJSON::encode($check),
                            'app' => Yii::app()->name,
                            'url' => Yii::app()->getBaseUrl(true),
                            'version' => Yii::app()->getModule('yupe')->getVersion()
                        ]
                    ]
                )->json();

                Yii::log(sprintf('Stop get updates from server...%s', json_encode($data)), \CLogger::LEVEL_INFO, static::LOG_CATEGORY);

                Yii::app()->getCache()->set('yupe::update::info', $data, $this->cacheTime);
            }

            return $data;
        } catch (\Exception $e) {

            Yii::log($e->__toString(), \CLogger::LEVEL_ERROR, static::LOG_CATEGORY);

            return false;
        }
    }

    /**
     * @return bool|int
     */
    public function getUpdatesCount()
    {
        $data = Yii::app()->getCache()->get('yupe::update::list');

        if (false === $data) {
            return false;
        }

        return count($data);
    }


    /**
     * @param $module
     * @param $version
     * @return bool
     */
    public function getModuleRemoteFile($module, $version)
    {
        try {

            $moduleFilePath = $this->getUploadPathForModule($module, $this->escapeVersion($version));

            Yii::log(
                sprintf('Get remote file for module "%s"...', $module),
                \CLogger::LEVEL_INFO,
                static::LOG_CATEGORY
            );

            // получить сам файл модуля
            $this->client->get(
                $this->getModuleUrl,
                [
                    'query' => [
                        'module' => $module,
                        'version' => $version,
                        'md5' => false
                    ],
                    'save_to' => $moduleFilePath
                ]
            );

            if(!file_exists($moduleFilePath)) {
                Yii::log(
                    sprintf('Error save file for module "%s" to "%s"...', $module, $moduleFilePath),
                    \CLogger::LEVEL_ERROR,
                    static::LOG_CATEGORY
                );

                throw new \CException(sprintf('Error save file for module "%s" to "%s"...', $module, $md5FilePath));
            }

            Yii::log(
                sprintf('Success save module file "%s" for module "%s"...',$moduleFilePath,  $module),
                \CLogger::LEVEL_INFO,
                static::LOG_CATEGORY
            );

            $md5FilePath = $this->getUploadPathForModule($module, $this->escapeVersion($version), true);

            Yii::log(
                sprintf('Get remote md5 file for module "%s"...', $module),
                \CLogger::LEVEL_INFO,
                static::LOG_CATEGORY
            );

            //получить md5-файл
            $this->client->get(
                $this->getModuleUrl,
                [
                    'query' => [
                        'module' => $module,
                        'version' => $version,
                        'md5' => true
                    ],
                    'save_to' => $md5FilePath
                ]
            );

            if(!file_exists($md5FilePath)) {
                Yii::log(
                    sprintf('Error save md5 file for module "%s" to "%s"...', $module, $md5FilePath),
                    \CLogger::LEVEL_ERROR,
                    static::LOG_CATEGORY
                );

                throw new \CException(sprintf('Error save md5 file for module "%s" to "%s"...', $module, $md5FilePath));
            }

            Yii::log(
                sprintf('Success save md5 file for module "%s" to "%s"...', $module, $md5FilePath),
                \CLogger::LEVEL_INFO,
                static::LOG_CATEGORY
            );

            //проверить md5

            Yii::log(
                sprintf('Success check md5 file for module "%s"...', $module),
                \CLogger::LEVEL_INFO,
                static::LOG_CATEGORY
            );

            $downloadedMd5 = md5_file($moduleFilePath);

            $actualMd5 = @file_get_contents($md5FilePath);

            if ($downloadedMd5 != $actualMd5) {
                Yii::log(sprintf('MD5 error for module "%s"..."%s" vs "%s"', $module, $downloadedMd5, $actualMd5), \CLogger::LEVEL_ERROR, static::LOG_CATEGORY);
                throw new \CException(sprintf('MD5 error for module "%s"..."%s" vs "%s"', $module, $downloadedMd5, $actualMd5));
            }

            return true;
        } catch (\Exception $e) {

            Yii::log(
                sprintf('Error download module file. %s', $e->__toString()),
                \CLogger::LEVEL_ERROR,
                static::LOG_CATEGORY
            );

            YFile::rmIfExists($this->getUploadPathForModule($module, $this->escapeVersion($version)));

            YFile::rmIfExists($this->getUploadPathForModule($module, $this->escapeVersion($version), true));

            return false;
        }
    }

    /**
     * @param $module
     * @param $version
     * @param bool $md5
     * @return string
     */
    public function getUploadPathForModule($module, $version, $md5 = false)
    {
        $extension = $md5 ? 'md5' : $this->moduleFileExtension;

        return $this->module->updateTmpPath . DIRECTORY_SEPARATOR . $module . '-' . $version . '.' . $extension;
    }

    /**
     * @param $version
     * @return mixed
     */
    public function escapeVersion($version)
    {
        return str_replace('.', '-', $version);
    }

    /**
     * @param $module
     * @param $version
     * @return bool
     */
    public function update($module, $version)
    {
        try {
            Yii::log(
                sprintf('Start update module "%s" to version "%s"...', $module, $version),
                \CLogger::LEVEL_INFO,
                static::LOG_CATEGORY
            );

            $moduleZipPath = $this->getUploadPathForModule($module, $this->escapeVersion($version));

            if (!file_exists($moduleZipPath)) {
                throw new CException(sprintf('File "%s" not found for module "%s"...', $moduleZipPath, $module));
            }

            $destination = Yii::getPathOfAlias(
                    'application.modules'
                ) . DIRECTORY_SEPARATOR . $module . '-' . $this->escapeVersion($version);

            $modulePath = Yii::getPathOfAlias("application.modules.{$module}");

            $modulesPath = Yii::getPathOfAlias("application.modules");

            if (!is_writable($modulesPath)) {
                throw new CException(
                    sprintf('Error extract zip file. Directory %s not writable...', $modulesPath)
                );
            }

            $backupPath = $modulePath . '_';

            $this->cleanUp($module, $version);

            Yii::log(sprintf('Try unzip files for module "%s"...', $module), \CLogger::LEVEL_INFO, static::LOG_CATEGORY);

            $zip = new \ZipArchive;

            if (false === $zip->open($moduleZipPath)) {
                $zip->close();
                throw new CException(
                    sprintf('Error open zip file "%s" file for module "%s"...', $moduleZipPath, $module)
                );
            }

            if (false === $zip->extractTo($destination)) {
                $zip->close();
                throw new CException(
                    sprintf('Error extract zip file "%s" file for module "%s"...', $moduleZipPath, $module)
                );
            }

            $zip->close();

            //переименовать текущий каталог
            if (false === rename($modulePath, $backupPath)) {
                throw new CException(sprintf('Error rename "%s" dir to backup dir "%s"...', $modulePath, $backupPath));
            }

            if (false === rename($destination, $modulePath)) {
                throw new CException(sprintf('Error rename "%s" dir to "%s"...', $destination, $modulePath));
            }

            if (false === YFile::rmDir($backupPath)) {
                throw new CException(sprintf('Error rm old dir "%s" for module "%s"...', $backupPath));
            }

            //обновить конфиг модуля
            $this->moduleManager->updateModuleConfig(Yii::app()->getModule($module));

            //накатить новые миграции модуя
            $this->migrator->updateToLatest($module);

            $this->cache->flush();

            Yii::log(
                sprintf('Finish install "%s" version "%s"...', $module, $version),
                \CLogger::LEVEL_INFO,
                static::LOG_CATEGORY
            );

            return true;
        } catch (\Exception $e) {
            Yii::log(
                sprintf('Error install module "%s" "%s"', $module, $e->__toString()),
                \CLogger::LEVEL_ERROR,
                static::LOG_CATEGORY
            );

            $this->cleanUp($module, $version, true);

            return true;
        }
    }

    protected function cleanUp($module, $version, $rmUploaded = false)
    {
        Yii::log(
            sprintf('Start cleanup module "%s" version "%s"...', $module, $version),
            \CLogger::LEVEL_INFO,
            static::LOG_CATEGORY
        );

        $destination = Yii::getPathOfAlias(
                'application.modules'
            ) . DIRECTORY_SEPARATOR . $module . '-' . $this->escapeVersion($version);

        if (is_dir($destination)) {
            Yii::log(sprintf('Deleting %s dir...', $destination), \CLogger::LEVEL_INFO, static::LOG_CATEGORY);
            YFile::rmDir($destination);
        }

        $modulePath = Yii::getPathOfAlias("application.modules.{$module}");

        $backupPath = $modulePath . '_';

        if (is_dir($backupPath)) {
            Yii::log(sprintf('Deleting backup path %s...', $backupPath), \CLogger::LEVEL_INFO, static::LOG_CATEGORY);
            YFile::rmDir($backupPath);
        }

        if ($rmUploaded) {

            YFile::rmIfExists($this->getUploadPathForModule($module, $this->escapeVersion($version)));

            YFile::rmIfExists($this->getUploadPathForModule($module, $this->escapeVersion($version), true));
        }

        Yii::log(
            sprintf('Stop cleanup module "%s" version "%s"...', $module, $version),
            \CLogger::LEVEL_INFO,
            static::LOG_CATEGORY
        );
    }
} 
