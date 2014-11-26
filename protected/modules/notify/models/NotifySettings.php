<?php

/**
 * This is the model class for table "{{notify_settings}}".
 *
 * The followings are the available columns in table '{{notify_settings}}':
 * @property integer $id
 * @property integer $user_id
 * @property integer $my_post
 * @property integer $my_comment
 *
 * The followings are the available model relations:
 * @property UserUser $user
 */
class NotifySettings extends \yupe\models\YModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{notify_settings}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return [
			['user_id', 'required'],
            ['user_id', 'unique'],
			['user_id, my_post, my_comment', 'numerical', 'integerOnly'=>true],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			['id, user_id, my_post, my_comment', 'safe', 'on'=>'search'],
		];
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
			'id' => 'ID',
			'user_id' => Yii::t('NotifyModule.notify', 'User'),
			'my_post' => Yii::t('NotifyModule.notify', 'My post comment'),
			'my_comment' => Yii::t('NotifyModule.notify', 'My comment answer'),
		];
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
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('my_post',$this->my_post);
		$criteria->compare('my_comment',$this->my_comment);

		return new CActiveDataProvider($this, [
			'criteria'=>$criteria,
		]);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return NotifySettings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getForUser($userId)
    {
        return $this->find('user_id = :id', [':id' => $userId]);
    }

    public function isNeedSendForCommentAnswer()
    {
        return $this->my_comment;
    }

    public function isNeedSendForNewPostComment()
    {
        return $this->my_post;
    }

    public function create($userId)
    {
        if($this->getIsNewRecord()) {
            $this->user_id = (int)$userId;
            return $this->save();
        }
        return true;
    }
}
