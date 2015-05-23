<?php
/**
 * Migrator class file.
 *
 * @category YupeComponent
 * @package  yupe.modules.yupe.components
 * @author   Alexander Tischenko <tsm@glavset.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version  0.5.3
 * @link     http://www.yupe.ru
 */

namespace yupe\components;

use Yii;
use CDbCacheDependency;
use ErrorException;
use CException;
use CDbConnection;
use TagsCache;
use CHtml;

class Migrator extends \CApplicationComponent
{
    public $connectionID = 'db';
    public $migrationTable = 'migrations';

    /**
     * @var CDbConnection
     */
    private $_db;

    /**
     * Инициализируем класс:
     *
     * @return parent:init()
     **/
    public function init()
    {
        // check for table
        $db = $this->getDbConnection();
        if ($db->schema->getTable($db->tablePrefix . $this->migrationTable) === null) {
            $this->createMigrationHistoryTable();
        }

        return parent::init();
    }

    /**
     * Обновление до актуальной миграции:
     *
     * @param string $module - required module
     *
     * @return bool if migration updated
     **/
    public function updateToLatest($module)
    {
        if (($newMigrations = $this->getNewMigrations($module)) !== []) {

            if(Yii::app()->hasComponent('cache')) {
                Yii::app()->getComponent('cache')->flush();
            }

            Yii::log(
                Yii::t(
                    'YupeModule.yupe',
                    'Updating DB of {module}  to latest version',
                    ['{module}' => $module]
                )
            );

            foreach ($newMigrations as $migration) {
                if ($this->migrateUp($module, $migration) === false) {
                    return false;
                }
            }

            if(Yii::app()->hasComponent('cache')) {
                Yii::app()->getComponent('cache')->flush();
            }

        } else {
            Yii::log(
                Yii::t(
                    'YupeModule.yupe',
                    'There is no new migrations for {module}',
                    ['{module}' => $module]
                )
            );
        }

        return true;
    }

    /**
     * Проверяем на незавершённые миграции:
     *
     * @param string $module - required module
     * @param bool $class - migration class
     *
     * @return bool is updated to migration
     **/
    public function checkForBadMigration($module, $class = false)
    {
        echo Yii::t('YupeModule.yupe', "Checking for pending migrations") . '<br />';

        $db = $this->getDbConnection();

        $data = $db->cache(
            3600,
            new CDbCacheDependency('select count(id) from ' . $db->tablePrefix . $this->migrationTable)
        )->createCommand()
            ->selectDistinct('version, apply_time')
            ->from($db->tablePrefix . $this->migrationTable)
            ->order('id DESC')
            ->where(
                'module = :module',
                [
                    ':module' => $module,
                ]
            )
            ->queryAll();

        if (($data !== []) || ((strpos($class, '_base') !== false) && ($data[] = [
                    'version'    => $class,
                    'apply_time' => 0
                ]))
        ) {
            foreach ($data as $migration) {
                if ($migration['apply_time'] == 0) {
                    try {
                        echo Yii::t(
                                'YupeModule.yupe',
                                'Downgrade {migration} for {module}.',
                                [
                                    '{module}'    => $module,
                                    '{migration}' => $migration['version'],
                                ]
                            ) . '<br />';
                        Yii::log(
                            Yii::t(
                                'YupeModule.yupe',
                                'Downgrade {migration} for {module}.',
                                [
                                    '{module}'    => $module,
                                    '{migration}' => $migration['version'],
                                ]
                            )
                        );
                        if ($this->migrateDown($module, $migration['version']) !== false) {
                            $db->createCommand()->delete(
                                $db->tablePrefix . $this->migrationTable,
                                [
                                    $db->quoteColumnName('version') . "=" . $db->quoteValue($migration['version']),
                                    $db->quoteColumnName('module') . "=" . $db->quoteValue($module),
                                ]
                            );
                        } else {
                            Yii::log(
                                Yii::t(
                                    'YupeModule.yupe',
                                    'Can\'t downgrade migrations {migration} for {module}.',
                                    [
                                        '{module}'    => $module,
                                        '{migration}' => $migration['version'],
                                    ]
                                )
                            );
                            echo Yii::t(
                                    'YupeModule.yupe',
                                    'Can\'t downgrade migrations {migration} for {module}.',
                                    [
                                        '{module}'    => $module,
                                        '{migration}' => $migration['version'],
                                    ]
                                ) . '<br />';

                            return false;
                        }
                    } catch (ErrorException $e) {
                        Yii::log(
                            Yii::t(
                                'YupeModule.yupe',
                                'There is an error: {error}',
                                [
                                    '{error}' => $e
                                ]
                            )
                        );
                        echo Yii::t(
                            'YupeModule.yupe',
                            'There is an error: {error}',
                            [
                                '{error}' => $e
                            ]
                        );
                    }
                }
            }
        } else {
            Yii::log(
                Yii::t(
                    'YupeModule.yupe',
                    'No need to downgrade migrations for {module}',
                    ['{module}' => $module]
                )
            );
            echo Yii::t(
                    'YupeModule.yupe',
                    'No need to downgrade migrations for {module}',
                    ['{module}' => $module]
                ) . '<br />';
        }

        return true;
    }

    /**
     * Обновляем миграцию:
     *
     * @param string $module - required module
     * @param string $class - name of migration class
     *
     * @return bool is updated to migration
     **/
    protected function migrateUp($module, $class)
    {
        $db = $this->getDbConnection();

        ob_start();
        ob_implicit_flush(false);

        echo Yii::t('YupeModule.yupe', "Checking migration {class}", ['{class}' => $class]);
        Yii::app()->getCache()->clear('getMigrationHistory');

        $start = microtime(true);
        $migration = $this->instantiateMigration($module, $class);

        // Вставляем запись о начале миграции
        $db->createCommand()->insert(
            $db->tablePrefix . $this->migrationTable,
            [
                'version'    => $class,
                'module'     => $module,
                'apply_time' => 0,
            ]
        );

        $result = $migration->up();
        Yii::log($msg = ob_get_clean());

        if ($result !== false) {
            // Проставляем "установлено"
            $db->createCommand()->update(
                $db->tablePrefix . $this->migrationTable,
                ['apply_time' => time()],
                "version = :ver AND module = :mod",
                [':ver' => $class, 'mod' => $module]
            );
            $time = microtime(true) - $start;
            Yii::log(
                Yii::t(
                    'YupeModule.yupe',
                    "Migration {class} applied for {s} seconds.",
                    ['{class}' => $class, '{s}' => sprintf("%.3f", $time)]
                )
            );
        } else {
            $time = microtime(true) - $start;
            Yii::log(
                Yii::t(
                    'YupeModule.yupe',
                    "Error when running {class} ({s} seconds.)",
                    ['{class}' => $class, '{s}' => sprintf("%.3f", $time)]
                )
            );
            throw new CException(
                Yii::t(
                    'YupeModule.yupe',
                    'Error was found when installing: {error}',
                    [
                        '{error}' => $msg
                    ]
                )
            );
        }
    }

    /**
     * Даунгрейд миграции:
     *
     * @param string $module - required module
     * @param string $class - name of migration class
     *
     * @return bool is downgraded from migration
     **/
    public function migrateDown($module, $class)
    {
        Yii::log(Yii::t('YupeModule.yupe', "Downgrade migration {class}", ['{class}' => $class]));
        $db = $this->getDbConnection();
        $start = microtime(true);
        $migration = $this->instantiateMigration($module, $class);

        ob_start();
        ob_implicit_flush(false);
        $result = $migration->down();
        Yii::log($msg = ob_get_clean());
        Yii::app()->getCache()->clear('getMigrationHistory');

        if ($result !== false) {
            $db->createCommand()->delete(
                $db->tablePrefix . $this->migrationTable,
                [
                    'AND',
                    $db->quoteColumnName('version') . "=" . $db->quoteValue($class),
                    [
                        'AND',
                        $db->quoteColumnName('module') . "=" . $db->quoteValue($module),
                    ]
                ]
            );
            $time = microtime(true) - $start;
            Yii::log(
                Yii::t(
                    'YupeModule.yupe',
                    "Migration {class} downgrated for {s} seconds.",
                    ['{class}' => $class, '{s}' => sprintf("%.3f", $time)]
                )
            );

            return true;
        } else {
            $time = microtime(true) - $start;
            Yii::log(
                Yii::t(
                    'YupeModule.yupe',
                    "Error when downgrading {class} ({s} сек.)",
                    ['{class}' => $class, '{s}' => sprintf("%.3f", $time)]
                )
            );
            throw new CException(
                Yii::t(
                    'YupeModule.yupe',
                    'Error was found when installing: {error}',
                    [
                        '{error}' => $msg
                    ]
                )
            );
        }
    }

    /**
     * Check each modules for new migrations
     *
     * @param string $module - required module
     * @param string $class - class of migration
     *
     * @return mixed version and apply time
     */
    protected function instantiateMigration($module, $class)
    {
        $file = Yii::getPathOfAlias("application.modules." . $module . ".install.migrations") . '/' . $class . '.php';
        include_once $file;
        $migration = new $class();
        $migration->setDbConnection($this->getDbConnection());

        return $migration;
    }

    /**
     * Connect to DB
     *
     * @return db connection or make exception
     */
    protected function getDbConnection()
    {

        if ($this->_db !== null) {
            return $this->_db;
        } else {
            if (($this->_db = Yii::app()->getComponent($this->connectionID)) instanceof CDbConnection) {
                return $this->_db;
            }
        }
        throw new CException(
            Yii::t('YupeModule.yupe', 'Parameter connectionID is wrong')
        );
    }

    /**
     * Check each modules for new migrations
     *
     * @param string $module - required module
     * @param integer $limit - limit of array
     *
     * @return mixed version and apply time
     */
    public function getMigrationHistory($module, $limit = 20)
    {
        $db = $this->getDbConnection();

        $allData = Yii::app()->getCache()->get('getMigrationHistory');

        if ($allData === false || !isset($allData[$module])) {

            Yii::app()->getCache()->clear('getMigrationHistory');

            $data = $db->cache(
                3600,
                new CDbCacheDependency('select count(id) from ' . $db->tablePrefix . $this->migrationTable)
            )->createCommand()
                ->select('version, apply_time')
                ->from($db->tablePrefix . $this->migrationTable)
                ->order('id DESC')
                ->where('module = :module', [':module' => $module])
                ->limit($limit)
                ->queryAll();

            $allData[$module] = $data;

            Yii::app()->getCache()->set(
                'getMigrationHistory',
                $allData,
                3600,
                new TagsCache('yupe', 'installedModules', 'getModulesDisabled', 'getMigrationHistory', $module)
            );

        } else {
            $data = $allData[$module];
        }

        return CHtml::listData($data, 'version', 'apply_time');
    }

    /**
     * Create migration history table
     *
     * @return nothing
     */
    protected function createMigrationHistoryTable()
    {
        $db = $this->getDbConnection();
        Yii::log(
            Yii::t(
                'YupeModule.yupe',
                'Creating table for store migration versions {table}',
                ['{table}' => $this->migrationTable]
            )
        );
        $options = Yii::app()->getDb()->schema instanceof \CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';
        $db->createCommand()->createTable(
            $db->tablePrefix . $this->migrationTable,
            [
                'id'         => 'pk',
                'module'     => 'string NOT NULL',
                'version'    => 'string NOT NULL',
                'apply_time' => 'integer',
            ],
            $options
        );

        $db->createCommand()->createIndex(
            "idx_migrations_module",
            $db->tablePrefix . $this->migrationTable,
            "module",
            false
        );
    }

    /**
     * Check for new migrations for module
     *
     * @param string $module - required module
     *
     * @return mixed new migrations
     */
    protected function getNewMigrations($module)
    {
        $applied = [];
        foreach ($this->getMigrationHistory($module, -1) as $version => $time) {
            if ($time) {
                $applied[substr($version, 1, 13)] = true;
            }
        }

        $migrations = [];

        if (($migrationsPath = Yii::getPathOfAlias("application.modules." . $module . ".install.migrations")) && is_dir(
                $migrationsPath
            )
        ) {
            $handle = opendir($migrationsPath);
            while (($file = readdir($handle)) !== false) {
                if ($file === '.' || $file === '..') {
                    continue;
                }
                $path = $migrationsPath . '/' . $file;
                if (preg_match('/^(m(\d{6}_\d{6})_.*?)\.php$/', $file, $matches) && is_file(
                        $path
                    ) && !isset($applied[$matches[2]])
                ) {
                    $migrations[] = $matches[1];
                }
            }
            closedir($handle);
            sort($migrations);
        }

        return $migrations;
    }

    /**
     * Check each modules for new migrations
     *
     * @param array $modules - list of modules
     *
     * @return mixed new migrations
     */
    public function checkForUpdates(array $modules)
    {
        $updates = [];

        foreach ($modules as $mid => $module) {
            if ($a = $this->getNewMigrations($mid)) {
                $updates[$mid] = $a;
            }
        }

        return $updates;
    }

    /**
     * Return db-installed modules list
     *
     * @return mixed db-installed
     **/
    public function getModulesWithDBInstalled()
    {
        $db = $this->getDbConnection();
        $modules = [];
        $m = $db->cache(
            3600,
            new CDbCacheDependency('select count(id) from ' . $db->tablePrefix . $this->migrationTable)
        )->createCommand()
            ->select('module')
            ->from($db->tablePrefix . $this->migrationTable)
            ->order('module DESC')
            ->group('module')
            ->queryAll();

        foreach ($m as $i) {
            $modules[] = $i['module'];
        }

        return $modules;
    }

    /**
     * Return installed modules id
     *
     * @return array
     */
    public function getInstalledModulesList()
    {
        $modules = [];

        foreach (Yii::app()->getModules() as $id => $config) {
            $modules[] = $id;
        }

        return $modules;
    }
}
