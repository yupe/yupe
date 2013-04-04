<?php
/**
 * Класс базовой модели, в которой определены необходимые методы
 * для работы.
 * Все модели, разработанные для Юпи! должны наследовать этот класс.
 *
 * @category YupeComponents
 * @package  Yupe
 * @abstract
 * @author   YupeTeam <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @version  0.0.4
 * @link     http://yupe.ru - основной сайт
 * 
 **/

/**
 * YModel - базовый класс для всех моделей Юпи!
 *
 * @category YupeComponents
 * @package  Yupe
 * @abstract
 * @author   YupeTeam <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @version  0.0.4
 * @link     http://yupe.ru - основной сайт
 * 
 **/
abstract class YModel extends Model
{
    public $cacheKey = false;
    /**
     * Функция получения id-модуля:
     *
     * @return string module-id
     **/
    public function getModuleID()
    {
        $rc = new ReflectionClass(get_class($this));
        $absModulesPath = Yii::app()->getBasePath('modules');
        $modulePath = dirname($rc->getFileName());
        $module = str_replace(
            array(
                $absModulesPath,
                'models',
                'modules',
                '/'
            ), '', $modulePath
        );

        return Yii::app()->hasModule($module)
            ? Yii::app()->getModule($module)->id
            : 'default';
    }

    /**
     * Метод хранящий описания атрибутов:
     *
     * @return array описания атрибутов
     **/
    public function attributeDescriptions()
    {
        return array();
    }

    /**
     * Метод получения описания атрибутов
     *
     * @param string $attribute - id-атрибута
     *
     * @return string описания атрибутов
     **/
    public function getAttributeDescription($attribute)
    {
        $descriptions = $this->attributeDescriptions();
        return (isset($descriptions[$attribute])) ? $descriptions[$attribute] : '';
    }

    /**
     * Переопределение фунеции кэширования
     *
     * @param integer          $duration   - the number of seconds that query results may remain valid in cache. If this is 0, the caching will be disabled.
     * @param CCacheDependency $dependency - the dependency that will be used when saving the query results into cache
     * @param integer          $queryCount - number of SQL queries that need to be cached after calling this method. Defaults to 1, meaning that the next SQL query will be cached.
     *
     * @return CActiveRecord the active record instance itself.
     **/
    public function cache($duration, $dependency=null, $queryCount=1)
    {
        $this->cacheKey='yii:dbschema'.$this->getDbConnection()->connectionString.':'.$this->getDbConnection()->username;
        return parent::cache('test', $dependency, $queryCount);
    }

    /**
     * Перехватываем метод applyScopes:
     *
     * @param CDbCriteria &$criteria - the query criteria
     *
     * @return void
     **/
    public function applyScopes(&$criteria)
    {
        parent::applyScopes($criteria);
        
        if ($this->cacheKey !== false && ($cache = Yii::app()->cache)) {
            
            $command = $this->getCommandBuilder()->createFindCommand($this->getTableSchema(), $criteria);
            
            $params = !empty($criteria->params)
                        ? ':' . $command->getText() . ':' . serialize($criteria->params)
                        : ':' . $this->tableName();
            
            $keys = array(
                $this->cacheKey . ':' . $this->tableName(),
                $this->cacheKey . ':' . $params
            );

            $append = !empty($cache[$this->moduleID])
                        ? $cache[$this->moduleID]
                        : array();

            if ($cache->get($keys[0]) !== null)
                $cache->set(
                    $this->moduleID, array_merge(
                        array(
                            md5($keys[0]) => $keys[0]
                        ), $append
                    )
                );
            elseif ($cache->get($keys[1]) !== null)
                $cache->set(
                    $this->moduleID, array_merge(
                        array(
                            md5($keys[1]) => $keys[1]
                        ), $append
                    )
                );
        }
    }
}