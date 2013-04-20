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
}