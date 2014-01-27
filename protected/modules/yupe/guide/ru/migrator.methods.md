Методы компонента "Мигратор"
============================

Компонент "Мигратор" - предназначен для использования миграций из веб части. То есть это по сути тот же компонент, который используется в Yii, но переписан с учётом специфики работы в фронт-части.

Компонент доступен из namespace'a `yupe\components\Migrator` и для своей работы использует следующие компоненты из глобального namespace'a:

* Yii;
* CDbCacheDependency;
* ErrorException;
* CException;
* CDbConnection;
* TagsCache;
* CHtml;

Методы
------

### Метод init - Инициализируем класс

[листинг](https://github.com/yupe/yupe/blob/master/protected/modules/yupe/components/Migrator.php#L38)

В данном методе перед инициализацией компонента проверяется наличие таблицы истории миграций, если же её нет - вызывается метод `createMigrationHistoryTable()`

### Метод updateToLatest - Обновление модуля до актуальной миграции

[листинг](https://github.com/yupe/yupe/blob/master/protected/modules/yupe/components/Migrator.php#L55)

В данном методе мы получаем список ещё не установленных миграций и постепенно "накатываем" их вызывая метод `migrateUp`. Если же список новых миграций пуст - сообщаем об этом в лог.

<pre>
@param string $module - id-модуля
@return bool true
</pre>

### Метод checkForBadMigration - Проверяем на незавершённые миграции:

[листинг](https://github.com/yupe/yupe/blob/master/protected/modules/yupe/components/Migrator.php#L55)

Метод проверяет список миграций на незавершённые ("плохие") миграции и возвращаем результат, есть таковые миграции у данного модуля или нет.

<pre>
@param string $module - id-модуля
@param string $class  - класс-миграции

@return bool обновились ли до миграции
</pre>

### Метод migrateUp - Обновляем миграцию:

[листинг](https://github.com/yupe/yupe/blob/master/protected/modules/yupe/components/Migrator.php#L210)

Метод "накатывания" миграции до нового состяния с записью результата в журнал миграций.

<pre>
@param string $module - required module
@param string $class  - name of migration class

@return bool is updated to migration
</pre>

### Метод migrateDown - Даунгрейд миграции:

[листинг](https://github.com/yupe/yupe/blob/master/protected/modules/yupe/components/Migrator.php#L282)

Метод "откатывания" миграции до старого состяния с удалением записи о данной миграции из журнала миграций.

<pre>
@param string $module - required module
@param string $class  - name of migration class

@return bool is downgraded to migration
</pre>

### Метод instantiateMigration - инициализация класса миграции:

[листинг](https://github.com/yupe/yupe/blob/master/protected/modules/yupe/components/Migrator.php#L345)

Инициализируем класс миграции для последующей работы с ним.

<pre>
@param string $module - required module
@param string $class  - class of migration

@return mixed version and apply time
</pre>

### Метод getDbConnection - получаем коннектор к БД

[листинг](https://github.com/yupe/yupe/blob/master/protected/modules/yupe/components/Migrator.php#L359)

<pre>@return db connection or make exception</pre>

### Метод getMigrationHistory - получаем историю миграций

[листинг](https://github.com/yupe/yupe/blob/master/protected/modules/yupe/components/Migrator.php#L382)

<pre>
@param string  $module - required module
@param integer $limit  - limit of array

@return mixed version and apply time
</pre>

### Метод createMigrationHistoryTable - создаём таблицу миграций

[листинг](https://github.com/yupe/yupe/blob/master/protected/modules/yupe/components/Migrator.php#L418)

<pre>@return nothing</pre>

### Метод getNewMigrations - проверка на наличие новых миграций для модуля

[листинг](https://github.com/yupe/yupe/blob/master/protected/modules/yupe/components/Migrator.php#L455)

<pre>
@param string $module - required module

@return mixed new migrations
</pre>

### Метод checkForUpdates - получение списка обновлений для выбранных модулей

[листинг](https://github.com/yupe/yupe/blob/master/protected/modules/yupe/components/Migrator.php#L496)

<pre>
@param array $modules - list of modules

@return mixed new migrations
</pre>

### Метод getModulesWithDBInstalled - получаем список модулей с установленными миграциями

[листинг](https://github.com/yupe/yupe/blob/master/protected/modules/yupe/components/Migrator.php#L514)

<pre>
@return mixed db-installed
</pre>



**При возникновении проблем - [напишите нам](http://amylabs.ru/contact)!**