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
	 * Получение ссылки на объект модели
	 * Это позволяет не писать каждый раз publiс static model в моделях Yii.
	 *
	 * @author Zalatov A.
	 *
	 * @param string $class_name Если необходимо, можно вручную указать имя класса
	 * @return $this
	 */
	public static function model($class_name = null) {
		if ($class_name === null) $class_name = get_called_class();
		return parent::model($class_name);
	}

	/**
	 * Получение имени класса
	 *
	 * Этот метод необходим, чтобы постараться избежать использования имени класса как строки.
	 * Метод get_class() принимает объект, поэтому не годится для статичного вызова.
	 * Например, в relations можно теперь вместо 'CatalogItem' указывать CatalogItem::_CLASS_().
	 * Это позволит использовать более точно Find Usages в IDE.
	 *
	 * Начиная с версии PHP > 5.5 есть магическая константа CLASS, которая аналогична.
	 * Но в целях совместимости с более старыми версиями PHP, рекомендуется использовать именно этот метод.
	 *
	 * @author Zalatov A.
	 *
	 * @return string
	 */
	public static function _CLASS_() {
		return get_called_class();
	}

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

	/**
	 * Выборка (scope) по условию, опубликована ли запись
	 * Предварительно проверяется, есть ли у модели необходимые для проверки атрибуты.
	 *
	 * @author Zalatov A.
	 *
	 * @return $this
	 */
	public function published() {
		$condition = array();// Список условий

		$tableAlias = $this->getTableAlias();// Получаем alias для модели, если, вдруг, модель подключена через relations

		// -- Если есть атрибут публикации, проверяем его
		if ($this->hasAttribute('is_published')) {// Проверяем флаг "опубликовано"
			$condition['publish'] = '`' . $tableAlias . '`.`is_published` = 1';
		} else if ($this->hasAttribute('publish_stamp')) {// Проверяем поле "дата публикации"
			$condition['publish'] = '`' . $tableAlias . '`.`publish_stamp` IS NOT NULL';
		}
		// -- -- -- --

		// -- Если есть атрибут проверки администратором, проверяем его
		if ($this->hasAttribute('is_approved')) {// Проверяем флаг "проверено"
			$condition['publish'] = '`' . $tableAlias . '`.`is_approved` = 1';
		} else if ($this->hasAttribute('approve_stamp')) {// Проверяем поле "дата проверки"
			$condition['publish'] = '`' . $tableAlias . '`.`approve_stamp` IS NOT NULL';
		}
		// -- -- -- --

		// -- Если есть аттрибут удаления записи, проверяем его
		if ($this->hasAttribute('is_deleted')) {// Проверяем флаг "удалено"
			$condition['delete'] = '`' . $tableAlias . '`.`is_deleted` = 0';
		} else if ($this->hasAttribute('delete_stamp')) {// Проверяем поле "Дата удаления"
			$condition['delete'] = '`' . $tableAlias . '`.`delete_stamp` IS NULL';
		}
		// -- -- -- --

		// -- Если у модели есть атрибуты для проверки, объединяем их в критерию
		if (count($condition) != 0) {
			$condition = implode(' AND ', $condition);

			$this->getDbCriteria()->mergeWith(array(
				'condition' => $condition,
			));
		}
		// -- -- -- --

		return $this;
	}
}