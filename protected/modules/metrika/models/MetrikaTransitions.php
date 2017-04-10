<?php

/**
 * This is the model class for table "{{metrika_transitions}}".
 *
 * The followings are the available columns in table '{{metrika_transitions}}':
 * @property integer $id
 * @property integer $url_id
 * @property string $date
 * @property string $params_get
 */
class MetrikaTransitions extends yupe\models\YModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{metrika_transitions}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('url_id', 'required'),
			array('url_id', 'numerical', 'integerOnly'=>true),
			array('params_get', 'length', 'max'=>250),
			array('id, url_id, date, params_get', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'url' => array(self::BELONGS_TO, 'MetrikaUrl', 'url_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('MetrikaModule.metrika', 'ID'),
			'url_id' => Yii::t('MetrikaModule.metrika', 'Url'),
			'date' => Yii::t('MetrikaModule.metrika', 'Date'),'',
			'params_get' => Yii::t('MetrikaModule.metrika', 'Params Get'),
		);
	}

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->date = new CDbExpression('now()');
        }

        return parent::beforeSave();
    }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('url_id',$this->url_id);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('params_get',$this->params_get,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MetrikaTransitions the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
