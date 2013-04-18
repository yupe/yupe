<?php

/**
 * This is the model class for table "{{RecoveryPassword}}".
 *
 * The followings are the available columns in table '{{RecoveryPassword}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $creation_date
 * @property string $code
 */
class RecoveryPassword extends YModel
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{user_recovery_password}}';
    }

    public function rules()
    {
        return array(
            array('user_id, code', 'required'),
            array('user_id', 'numerical', 'integerOnly' => true),
            array('code', 'length', 'max' => 32, 'min' => 32),
            array('code', 'unique'),
            array('id, user_id, creation_date, code', 'safe', 'on' => 'search'),
        );
    }

    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id'            => Yii::t('UserModule.user', 'Id'),
            'user_id'       => Yii::t('UserModule.user', 'Пользователь'),
            'creation_date' => Yii::t('UserModule.user', 'Дата создания'),
            'code'          => Yii::t('UserModule.user', 'Код'),
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('creation_date', $this->creation_date, true);
        $criteria->compare('code', $this->code, true);

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    public function generateRecoveryCode($user_id)
    {
        return md5(time() . $user_id . uniqid());
    }

    public function beforeSave()
    {
        if ($this->isNewRecord)
            $this->creation_date = new CDbExpression(Yii::app()->db->schema instanceof CSqliteSchema ? 'DATETIME("now")' :'NOW()');
        return parent::beforeSave();
    }
}