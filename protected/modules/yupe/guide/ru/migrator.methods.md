Методы компонента "Мигратор"
============================

**Автор**: [Комманда разработчиков Юпи!](http://yupe.ru/feedback/contact?from=docs)

**Версия**: 0.1 (dev)

**Авторское право**:  2009-2013 Yupe!

**Лицензия**: [BSD](https://github.com/yupe/yupe/blob/master/LICENSE)

Методы
------


### Метод init - Инициализируем класс

~~~
[php]
public function init()
{
    // check for table
    $db = $this->getDbConnection();
    if ($db->schema->getTable($db->tablePrefix . $this->migrationTable) === null) {
        $this->createMigrationHistoryTable();
    }
    return parent::init();
}
~~~

В данном методе перед инициализацией компонента проверяется наличие таблицы истории миграций, если же её нет - вызывается метод `createMigrationHistoryTable()`

### Метод updateToLatest - Обновление модуля до актуальной миграции

~~~
[php]
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
~~~

В данном методе мы получаем список ещё не установленных миграций и постепенно "накатываем" их вызывая метод `migrateUp`. Если же список новых миграций пуст - сообщаем об этом в лог.

@param string $module - id-модуля
@return bool true

### Метод checkForBadMigration - Проверяем на незавершённые миграции:

~~~
[php]
public function checkForBadMigration($module, $class = false)
{
    echo Yii::t('YupeModule.yupe', "Проверяем на наличие незавершённых миграций.") . '<br />';

    $db = $this->getDbConnection();

    // @TODO: add cache here??
    $data = $db->createCommand()
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
~~~

@param string $module - id-модуля
@param string $class  - класс-миграции

@return bool обновились ли до миграции
