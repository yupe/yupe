<?php

/**
 *
 * @package  yupe.modules.yupe.models
 *
 */

/**
 * This is the model class for table "Settings".
 *
 * The followings are the available columns in table 'Settings':
 * @property string $id
 * @property string $module_id
 * @property string $param_name
 * @property string $param_value
 * @property string $create_time
 * @property string $update_time
 * @property string $user_id
 *
 * The followings are the available model relations:
 * @property User $user
 */
namespace yupe\models;

use Yii;
use CDbExpression;
use CDbCriteria;
use CActiveDataProvider;
use CMap;
use TagsCache;

/**
 * Class Settings
 * @package yupe\models
 */
class Settings extends YModel
{
    /*
        TYPE_CORE - для модуля,
        TYPE_USER - для пользователей
    */
    /**
     *
     */
    const TYPE_CORE = 1;
    /**
     *
     */
    const TYPE_USER = 2;

    /**
     * @var array Массив хранящий список валидаторов для определенного параметра модуля
     */
    public $rulesFromModule = [];

    /**
     * Returns the static model of the specified AR class.
     * @return Settings the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{yupe_settings}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return CMap::mergeArray(
            [
                ['module_id, param_name', 'required'],
                ['module_id, param_name', 'length', 'max' => 100],
                ['param_value', 'length', 'max' => 255],
                ['user_id', 'numerical', 'integerOnly' => true],
                //array('module_id','match','pattern' => '/^[a-zA-Z0-9_\-]+$/'),
                //array('param_name, param_value','match','pattern' => '/^[a-zA-Z0-9_\-]+$/'),
                [
                    'id, module_id, param_name, param_value, create_time, update_time, user_id',
                    'safe',
                    'on' => 'search',
                ],
            ],
            $this->rulesFromModule
        );
    }

    /**
     * @return bool
     */
    public function beforeSave()
    {
        $this->update_time = new CDbExpression('NOW()');

        if ($this->getIsNewRecord()) {
            $this->create_time = $this->update_time;
        }

        // Пользователя можно получить только для веб-приложения
        $this->user_id = Yii::app()->hasComponent('user') ? Yii::app()->getUser()->getId() : null;

        return parent::beforeSave();
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
            'user' => [self::BELONGS_TO, 'User', 'user_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('YupeModule.yupe', 'ID'),
            'module_id' => Yii::t('YupeModule.yupe', 'Module'),
            'param_name' => Yii::t('YupeModule.yupe', 'Parameter name'),
            'param_value' => Yii::t('YupeModule.yupe', 'Parameter value'),
            'create_time' => Yii::t('YupeModule.yupe', 'Creation date'),
            'update_time' => Yii::t('YupeModule.yupe', 'Change date'),
            'user_id' => Yii::t('YupeModule.yupe', 'User'),
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id, true);
        $criteria->compare('module_id', $this->module_id, true);
        $criteria->compare('param_name', $this->param_name, true);
        $criteria->compare('param_value', $this->param_value, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('user_id', $this->user_id, true);

        return new CActiveDataProvider(get_class($this), ['criteria' => $criteria]);
    }


    /**
     * @param $moduleId
     * @param array|null $params
     * @return array
     */
    public static function fetchModuleSettings($moduleId, array $params = null)
    {

        $settings = [];

        if ($moduleId) {
            $criteria = new CDbCriteria();

            $criteria->compare("module_id", $moduleId);
            $criteria->compare("type", self::TYPE_CORE);
            if (!empty($params)) {
                $criteria->addInCondition("param_name", $params);
            }

            $dependency = new TagsCache($moduleId, 'yupe');

            $q = Settings::model()->cache(Yii::app()->getModule('yupe')->coreCacheTime, $dependency)->findAll(
                $criteria
            );

            if (count($q)) {
                foreach ($q as $s) {
                    $settings[$s->param_name] = $s;
                }
            } elseif (count($params)) {
                foreach ($params as $param) {
                    $settings[$param] = null;
                }
            }
        }

        return $settings;
    }


    /**
     * @param $moduleId
     * @param $paramValues
     * @return bool
     */
    public static function saveModuleSettings($moduleId, $paramValues)
    {
        foreach ($paramValues as $name => $value) {
            // Получаем настройку
            $setting = Settings::model()->find(
                'module_id = :module_id and param_name = :param_name',
                [':module_id' => $moduleId, ':param_name' => $name]
            );

            // Если новая запись
            if ($setting == null) {
                $setting = new Settings();
                $setting->module_id = $moduleId;
                $setting->param_name = $name;
            } // Если значение не изменилось то не сохраняем
            elseif ($setting->param_value == $value) {
                continue;
            }

            // Присваиваем новое значение
            $setting->param_value = $value;

            // Добавляем для параметра его правила валидации
            $setting->rulesFromModule = Yii::app()->getModule($moduleId)->getRulesForParam($name);

            //Сохраняем
            if (!$setting->save()) {
                return false;
            }
        }

        return true;
    }

    /**
     *  Получает настройки модуля/модулей из базы данных (пользователельские)
     *
     * @param string $userId - Идентификатор пользователя
     * @param mixed $modulesId - Список идентификаторов модулей
     *
     * @return array Экземпляры класса Settings, соответствующие запрошенным параметрам
     **/
    public function fetchUserModuleSettings($userId, $modulesId = [])
    {
        $settings = [];

        $criteria = new CDbCriteria();
        /* Выборка всех модулей или только указанных */
        if (!empty($modulesId)) {
            $criteria->addInCondition("module_id", $modulesId);
        }
        /* Выборка для определённого пользователя: */
        $criteria->compare("user_id", $userId);
        /* Выборка параметров клиентов */
        $criteria->compare("type", self::TYPE_USER);

        $result = $this->findAll($criteria);

        if (count($result)) {
            foreach ($result as $s) {
                $settings[] = $s;
            }
        }

        return $settings;
    }
}
