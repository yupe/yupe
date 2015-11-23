<?php
/**
 * DAO - simple DAO wrapper by AKulikov for Yupe
 *
 * @category YupeComponents
 * @package  yupe.modules.yupe.components
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     http://yupe.ru
 *
 */

namespace yupe\components;

use Yii;

class DAO extends \CComponent
{
    // CDbSchema instance, default - Yii::app()->getDb()->getSchema():
    private $_schema = null;

    // CDbCriteria intance:
    private $_criteria = null;

    // CDbCommand instance:
    private $_command = null;

    // Table Name, string:
    private $_tableName = null;

    // Query conditions, mixed:
    private $_conditions = null;

    // Query params, array
    private $_params = [];

    /**
     * Создаём новый инстанс класса
     * для использования статических
     * методов:
     *
     * @return DAO class (self)
     */
    public static function getInstance()
    {
        $instance = __CLASS__;
        $instance = new $instance();

        return $instance->init();
    }

    /**
     * Тестовый статический метод:
     *
     * @return DAO class (self)
     */
    public static function test()
    {
        return self::getInstance();
    }

    /**
     * Возвращаем объект критерии, в случае её отсутствия
     * создаём:
     *
     * @return CDbCriteria instance
     */
    protected function getCriteria()
    {
        return $this->_criteria
            ?: (
            $this->_criteria = new \CDbCriteria()
            );
    }

    /**
     * Возвращаем объект CDbCommand, в случае его отсутствия
     * создаём:
     *
     * @return CDbCommand instance
     */
    protected function getCommand()
    {
        return $this->_command
            ?: (
            $this->_command = Yii::app()
                ->getDb()
                ->createCommand()
            );
    }

    /**
     * Возвращаем объект CDbSchema, в случае её отсутствия
     * создаём:
     *
     * @return CDbSchema instance
     */
    protected function getSchema()
    {
        return $this->_schema
            ?: (
            $this->_schema = Yii::app()
                ->getDb()
                ->getSchema()
            );
    }

    /**
     * Инициализация класса, настройка окружения
     * и инициализация необходимых для работы классов:
     *
     * @return DAO class (self)
     */
    public function init()
    {
        return $this;
    }

    public static function wrapper()
    {
        return self::getInstance();
    }

    /**
     * render Table name
     *
     * @param string $table - name of table
     *
     * @return string - normalize name of table
     **/
    public function normTable($table)
    {
        return preg_replace(
            '/{{(.*?)}}/',
            $this->getSchema()->getDbConnection()->tablePrefix.'\1',
            $table
        );
    }

    /**
     * Добавляем критерию FROM для дальнейшей работы:
     *
     * @param  string $tableName - название таблицы
     * @return DAO    class (self)
     */
    public function in($tableName = null)
    {
        $this->_tableName = $this->normTable($tableName);

        return $this;
    }

    /**
     * Указываем пост-условия для запроса:
     *
     * @param mixed $conditions - the conditions that should be put in the WHERE part.
     * @param array $params - the parameters (name=>value) to be bound to the query
     *
     * @return [type] [description]
     */
    public function where($conditions, array $params = [])
    {
        $this->_conditions = $conditions;
        $this->_params = $params;

        return $this;
    }

    /**
     * Выполняем обновление записей:
     *
     * @param  array $columns - является массивом пар имя-значение,
     *                          задающим значения обновляемых полей
     * @return integer - number of rows affected by the execution.
     */
    public function update(array $columns = [])
    {
        return $this->getCommand()
            ->update(
                $this->_tableName,
                $columns,
                $this->_conditions,
                $this->_params
            );
    }
}
