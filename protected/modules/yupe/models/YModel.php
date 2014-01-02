<?php
/**
 * Класс базовой модели, в которой определены необходимые методы
 * для работы.
 * Все модели, разработанные для Юпи! должны наследовать этот класс.
 *
 * @category YupeComponents
 * @package  yupe.modules.yupe.models
 * @abstract
 * @author   YupeTeam <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @version  0.0.4
 * @link     http://yupe.ru - основной сайт
 * 
 **/

namespace yupe\models;

use CActiveRecord;
use ReflectionClass;
use TagsCache;
use CCacheDependency;
use CChainedCacheDependency;
use Yii;

abstract class YModel extends CActiveRecord
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

        return $module;
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
     * Загружаем можель по её PK
     *
     * @param mixed $id - primary key
     *
     * @return mixed null or instance of model
     **/
    public function loadModel($id = null)
    {
        return ($model = self::model(get_class($this))->findByPk($id)) !== null
            ? $model
            : null;
    }

    /**
     * Sets the parameters about query caching.
     * This is a shortcut method to {@link CDbConnection::cache()}.
     * It changes the query caching parameter of the {@link dbConnection} instance.
     * @param integer $duration the number of seconds that query results may remain valid in cache.
     * If this is 0, the caching will be disabled.
     * @param CCacheDependency $dependency the dependency that will be used when saving the query results into cache.
     * @param integer $queryCount number of SQL queries that need to be cached after calling this method. Defaults to 1,
     * meaning that the next SQL query will be cached.
     * @return CActiveRecord the active record instance itself.
     * @since 1.1.7
     */
    public function cache($duration, $dependency=null, $queryCount=1)
    {
        /**
         * Получаем "теги" для кеша
         */
        $model  = strtolower(get_class($this));
        $module = $model === 'settings' && !empty($this->module_id)
            ? $this->module_id
            : strtolower($this->moduleID);

        /**
         * Если не указана зависимость,
         * выставляем тегирование
         */
        if ($dependency === null) {
            return parent::cache($duration, new TagsCache($model, $module), $queryCount);
        }
        elseif ($dependency instanceof TagsCache){
            return parent::cache($duration, $dependency, $queryCount);
        }
        
        /**
         * Если же есть зависимость,
         * создаём цепочку и в неё добавляем
         * нужную зависимость + тегирование
         */
        $chain = new CChainedCacheDependency;
        $chain->dependencies->add($dependency);
        $chain->dependencies->add(new TagsCache($model, $module));

        return parent::cache($duration, $chain, $queryCount);
    }
}