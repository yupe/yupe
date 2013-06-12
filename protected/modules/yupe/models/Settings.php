<?php

/**
 * This is the model class for table "Settings".
 *
 * The followings are the available columns in table 'Settings':
 * @property string $id
 * @property string $module_id
 * @property string $param_name
 * @property string $param_value
 * @property string $creation_date
 * @property string $change_date
 * @property string $user_id
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Settings extends YModel
{
    /*
        TYPE_CORE - для модуля,
        TYPE_USER - для пользователей
    */
    const TYPE_CORE = 1;
    const TYPE_USER = 2;

    /**
     * @var array Массив хранящий список валидаторов для определенного параметра модуля
     */
    public $rulesFromModule = array();

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
        return CMap::mergeArray(array(
            array('module_id, param_name', 'required'),
            array('module_id, param_name', 'length', 'max' => 100),
            array('param_value', 'length', 'max' => 255),
            array('user_id', 'numerical', 'integerOnly' => true),
            //array('module_id','match','pattern' => '/^[a-zA-Z0-9_\-]+$/'),
            //array('param_name, param_value','match','pattern' => '/^[a-zA-Z0-9_\-]+$/'),
            array('id, module_id, param_name, param_value, creation_date, change_date, user_id', 'safe', 'on' => 'search'),
        ),$this->rulesFromModule);
    }

    public function beforeSave()
    {
        $this->change_date = YDbMigration::expression('NOW()');

        if ($this->isNewRecord)
            $this->creation_date = $this->change_date;

        if (!isset($this->user_id))
            $this->user_id = Yii::app()->user->getId();

        if ($this->user_id !== Yii::app()->user->getId())
            $this->user_id = Yii::app()->user->getId();

        return parent::beforeSave();
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'            => Yii::t('YupeModule.yupe', 'ID'),
            'module_id'     => Yii::t('YupeModule.yupe', 'Модуль'),
            'param_name'    => Yii::t('YupeModule.yupe', 'Имя параметра'),
            'param_value'   => Yii::t('YupeModule.yupe', 'Значение параметра'),
            'creation_date' => Yii::t('YupeModule.yupe', 'Дата создания'),
            'change_date'   => Yii::t('YupeModule.yupe', 'Дата изменения'),
            'user_id'       => Yii::t('YupeModule.yupe', 'Пользователь'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('module_id', $this->module_id, true);
        $criteria->compare('param_name', $this->param_name, true);
        $criteria->compare('param_value', $this->param_value, true);
        $criteria->compare('creation_date', $this->creation_date, true);
        $criteria->compare('change_date', $this->change_date, true);
        $criteria->compare('user_id', $this->user_id, true);

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    /**
     * Получает настройки модуля из базы данных (системные)
     *
     * @param string $module_id Идентификатор модуля
     * @param mixed $params Список параметров, которые требуется прочитать
     * @return array Экземпляры класса Settings, соответствующие запрошенным параметрам
     */
    public function fetchModuleSettings($moduleId, array $params = null)
    {

        $settings = array();

        if ($moduleId)
        {
            $criteria = new CDbCriteria();

            $criteria->compare("module_id", $moduleId);
            $criteria->compare("type", self::TYPE_CORE);
            if (!empty($params))
                $criteria->addInCondition("param_name", $params);

            $q = $this->cache(Yii::app()->getModule('yupe')->coreCacheTime)->findAll($criteria);

            if(count($q))
            {
                foreach ($q as $s)
                    $settings[$s->param_name] = $s;
            }
            elseif (count($params))
            {
                foreach($params as $param)
                    $settings[$param] = null;
            }
        }

        return $settings;
    }

    /**
     *  Получает настройки модуля/модулей из базы данных (пользователельские)
     *
     *  @param string $userId  - Идентификатор пользователя
     *  @param mixed  $modulesId - Список идентификаторов модулей
     *
     *  @return array Экземпляры класса Settings, соответствующие запрошенным параметрам
     **/
    public function fetchUserModuleSettings($userId, $modulesId = array())
    {
        $settings = array();

        $criteria = new CDbCriteria();
        /* Выборка всех модулей или только указанных */
        if (!empty($modulesId))
            $criteria->addInCondition("module_id", $modulesId);
        /* Выборка для определённого пользователя: */
        $criteria->compare("user_id", $userId);
        /* Выборка параметров клиентов */
        $criteria->compare("type", self::TYPE_USER);

        $result = $this->findAll($criteria);

        if (count($result)) {
            foreach ($result as $s)
                $settings[] = $s;
        }

        return $settings;
    }
}