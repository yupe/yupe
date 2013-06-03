<?php
/**
 * Migrator class file.
 *
 * @category YupeComponent
 * @package  YupeCMS
 * @author   Alexander Tischenko <tsm@glavset.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version  0.5.3
 * @link     http://www.yupe.ru
 */

/**
 * Migrator class file.
 *
 * @category YupeComponent
 * @package  YupeCMS
 * @author   Alexander Tischenko <tsm@glavset.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version  0.5.3
 * @link     http://www.yupe.ru
 */
class Migrator extends CApplicationComponent
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
        if (($newMigrations = $this->getNewMigrations($module)) !== array()) {
            Yii::log(
                Yii::t(
                    'YupeModule.yupe',
                    'Обновляем до последней версии базы модуль {module}',
                    array('{module}' => $module)
                )
            );
            foreach ($newMigrations as $migration) {
                if ($this->migrateUp($module, $migration) === false) {
                    return false;
                }
            }
        } else {
            Yii::log(
                Yii::t(
                    'YupeModule.yupe',
                    'Для модуля {module} новых миграций не найдено',
                    array('{module}' => $module)
                )
            );
        }
        return true;
    }

    /**
     * Проверяем на незавершённые миграции:
     *
     * @param string $module - required module
     * @param string $class  - migration class
     *
     * @return bool is updated to migration
     **/
    public function checkForBadMigration($module, $class = false)
    {
        echo Yii::t('YupeModule.yupe', "Проверяем на наличие незавершённых миграций.") . '<br />';

        $db = $this->getDbConnection();

        $data = $db->cache(
                3600, new CDbCacheDependency('select count(id) from ' . $db->tablePrefix . $this->migrationTable)
            )->createCommand()
            ->selectDistinct('version, apply_time')
            ->from($db->tablePrefix . $this->migrationTable)
            ->order('version DESC')
            ->where(
                'module = :module',
                array(
                    ':module' => $module,
                )
            )
            ->queryAll();

        if (($data !== array()) || ((strpos($class, '_base') !== false) && ($data[] = array(
            'version' => $class,
            'apply_time' => 0
        )))
        ) {
            foreach ($data as $migration) {
                if ($migration['apply_time'] == 0) {
                    try {
                        echo Yii::t(
                            'YupeModule.yupe',
                            'Откат миграции {migration} для модуля {module}.',
                            array(
                                '{module}' => $module,
                                '{migration}' => $migration['version'],
                            )
                        ) . '<br />';
                        Yii::log(
                            Yii::t(
                                'YupeModule.yupe',
                                'Откат миграции {migration} для модуля {module}.',
                                array(
                                    '{module}' => $module,
                                    '{migration}' => $migration['version'],
                                )
                            )
                        );
                        if ($this->migrateDown($module, $migration['version']) !== false) {
                            $db->createCommand()->delete(
                                $db->tablePrefix . $this->migrationTable,
                                array(
                                    $db->quoteColumnName('version') . "=" . $db->quoteValue($migration['version']),
                                    $db->quoteColumnName('module') . "=" . $db->quoteValue($module),
                                )
                            );
                        } else {
                            Yii::log(
                                Yii::t(
                                    'YupeModule.yupe',
                                    'Не удалось выполнить откат миграции {migration} для модуля {module}.',
                                    array(
                                        '{module}' => $module,
                                        '{migration}' => $migration['version'],
                                    )
                                )
                            );
                            echo Yii::t(
                                'YupeModule.yupe',
                                'Не удалось выполнить откат миграции {migration} для модуля {module}.',
                                array(
                                    '{module}' => $module,
                                    '{migration}' => $migration['version'],
                                )
                            ) . '<br />';
                            return false;
                        }
                    } catch (ErrorException $e) {
                        Yii::log(
                            Yii::t(
                                'YupeModule.yupe',
                                'Произошла ошибка: {error}',
                                array(
                                    '{error}' => $e
                                )
                            )
                        );
                        echo Yii::t(
                            'YupeModule.yupe',
                            'Произошла ошибка: {error}',
                            array(
                                '{error}' => $e
                            )
                        );
                    }
                }
            }
        } else {
            Yii::log(
                Yii::t(
                    'YupeModule.yupe',
                    'Для модуля {module} не требуется откат миграции.',
                    array('{module}' => $module)
                )
            );
            echo Yii::t(
                'YupeModule.yupe',
                'Для модуля {module} не требуется откат миграции.',
                array('{module}' => $module)
            ) . '<br />';
        }
        return true;
    }

    /**
     * Обновляем миграцию:
     *
     * @param string $module - required module
     * @param string $class  - name of migration class
     *
     * @return bool is updated to migration
     **/
    protected function migrateUp($module, $class)
    {
        $db = $this->getDbConnection();

        ob_start();
        ob_implicit_flush(false);

        echo Yii::t('YupeModule.yupe', "Применяем миграцию {class}", array('{class}' => $class));
        Yii::app()->cache->clear('getMigrationHistory');

        $start = microtime(true);
        $migration = $this->instantiateMigration($module, $class);

        // Вставляем запись о начале миграции
        $db->createCommand()->insert(
            $db->tablePrefix . $this->migrationTable,
            array(
                'version' => $class,
                'module' => $module,
                'apply_time' => 0,
            )
        );

        $result = $migration->up();
        Yii::log($msg = ob_get_clean());

        if ($result !== false) {
            // Проставляем "установлено"
            $db->createCommand()->update(
                $db->tablePrefix . $this->migrationTable,
                array('apply_time' => time()),
                "version = :ver AND module = :mod",
                array(':ver' => $class, 'mod' => $module)
            );
            $time = microtime(true) - $start;
            Yii::log(
                Yii::t(
                    'YupeModule.yupe',
                    "Миграция {class} применена за {s} сек.",
                    array('{class}' => $class, '{s}' => sprintf("%.3f", $time))
                )
            );
        } else {
            $time = microtime(true) - $start;
            Yii::log(
                Yii::t(
                    'YupeModule.yupe',
                    "Ошибка применения миграции {class} ({s} сек.)",
                    array('{class}' => $class, '{s}' => sprintf("%.3f", $time))
                )
            );
            throw new CException(
                Yii::t(
                    'YupeModule.yupe',
                    'Во время установки возникла ошибка: {error}',
                    array(
                        '{error}' => $msg
                    )
                )
            );
            return false;
        }
    }

    /**
     * Даунгрейд миграции:
     *
     * @param string $module - required module
     * @param string $class  - name of migration class
     *
     * @return bool is downgraded from migration
     **/
    public function migrateDown($module, $class)
    {
        Yii::log(Yii::t('YupeModule.yupe', "Отменяем миграцию {class}", array('{class}' => $class)));
        $db = $this->getDbConnection();
        $start = microtime(true);
        $migration = $this->instantiateMigration($module, $class);

        ob_start();
        ob_implicit_flush(false);
        $result = $migration->down();
        Yii::log($msg = ob_get_clean());
        Yii::app()->cache->clear('getMigrationHistory');

        if ($result !== false) {
            $db->createCommand()->delete(
                $db->tablePrefix . $this->migrationTable,
                array(
                    'AND',
                    $db->quoteColumnName('version') . "=" . $db->quoteValue($class),
                    array(
                        'AND',
                        $db->quoteColumnName('module') . "=" . $db->quoteValue($module),
                    )
                )
            );
            $time = microtime(true) - $start;
            Yii::log(
                Yii::t(
                    'YupeModule.yupe',
                    "Миграция {class} отменена за {s} сек.",
                    array('{class}' => $class, '{s}' => sprintf("%.3f", $time))
                )
            );
            return true;
        } else {
            $time = microtime(true) - $start;
            Yii::log(
                Yii::t(
                    'YupeModule.yupe',
                    "Ошибка отмены миграции {class} ({s} сек.)",
                    array('{class}' => $class, '{s}' => sprintf("%.3f", $time))
                )
            );
            throw new CException(
                Yii::t(
                    'YupeModule.yupe',
                    'Во время установки возникла ошибка: {error}',
                    array(
                        '{error}' => $msg
                    )
                )
            );
        }
    }

    /**
     * Check each modules for new migrations
     *
     * @param string $module - required module
     * @param string $class  - class of migration
     *
     * @return mixed version and apply time
     */
    protected function instantiateMigration($module, $class)
    {
        $file = Yii::getPathOfAlias("application.modules." . $module . ".install.migrations") . '/' . $class . '.php';
        include_once $file;
        $migration = new $class;
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
            Yii::t('YupeModule.yupe', 'Неверно указан параметр connectionID')
        );
    }

    /**
     * Check each modules for new migrations
     *
     * @param string  $module - required module
     * @param integer $limit  - limit of array
     *
     * @return mixed version and apply time
     */
    public function getMigrationHistory($module, $limit = 20)
    {
        $db = $this->getDbConnection();

        #Yii::app()->cache->clear('getMigrationHistory');

        $allData = Yii::app()->cache->get('getMigrationHistory');

        if ($allData === false || !isset($allData[$module])) {

            Yii::app()->cache->clear('getMigrationHistory');

            $data = $db->cache(
                    3600, new CDbCacheDependency('select count(id) from ' . $db->tablePrefix . $this->migrationTable)
                )->createCommand()
                ->select('version, apply_time')
                ->from($db->tablePrefix . $this->migrationTable)
                ->order('version DESC')
                ->where('module = :module', array(':module' => $module))
                ->limit($limit)
                ->queryAll();

            $allData[$module] = $data;

            Yii::app()->cache->set('getMigrationHistory', $allData, 3600, new TagsCache('yupe', 'installedModules', 'getModulesDisabled', 'getMigrationHistory', $module));

        } else
            $data = $allData[$module];

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
                'Создаем таблицу для хранения версий миграций {table}',
                array('{table}' => $this->migrationTable)
            )
        );
        $options = Yii::app()->db->schema instanceof CMysqlSchema ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8' : '';
        $db->createCommand()->createTable(
            $db->tablePrefix . $this->migrationTable,
            array(
                'id' => 'pk',
                'module' => 'string NOT NULL',
                'version' => 'string NOT NULL',
                'apply_time' => 'integer',
            ),
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
        $applied = array();
        foreach ($this->getMigrationHistory($module, -1) as $version => $time) {
            if ($time) {
                $applied[substr($version, 1, 13)] = true;
            }
        }

        $migrations = array();

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
    public function checkForUpdates($modules)
    {

        $db = $this->getDbConnection();
        $updates = array();

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
        $modules = array();
        $m = $db->cache(
                3600, new CDbCacheDependency('select count(id) from ' . $db->tablePrefix . $this->migrationTable)
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
}