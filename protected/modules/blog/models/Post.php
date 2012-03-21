<?php

/**
 * This is the model class for table "post".
 *
 * The followings are the available columns in table 'post':
 * @property string $id
 * @property string $blog_id
 * @property string $create_user_id
 * @property string $update_user_id
 * @property integer $create_date
 * @property integer $update_date
 * @property string $slug
 * @property string $publish_date
 * @property string $title
 * @property string $quote
 * @property string $content
 * @property string $link
 * @property integer $status
 * @property integer $comment_status
 * @property integer $access_type
 * @property string $keywords
 * @property string $description
 *
 * The followings are the available model relations:
 * @property User $createUser
 * @property User $updateUser
 * @property Blog $blog
 */
class Post extends CActiveRecord
{
	const STATUS_DRAFT     = 0;

	const STATUS_PUBLISHED = 1;	

	const STATUS_SHEDULED  = 2;

	const ACCESS_PUBLIC  = 1;

	const ACCESS_PRIVATE = 2;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Post the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{post}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('blog_id, slug, publish_date, title, content', 'required'),
			array('blog_id, create_user_id, update_user_id, create_date, update_date, status, comment_status, access_type', 'numerical', 'integerOnly'=>true),
			array('blog_id, create_user_id, update_user_id', 'length', 'max'=>10),
			array('slug, title, link, keywords', 'length', 'max'=>150),
			array('quote, description', 'length', 'max'=>300),
			array('link','url'),
			array('comment_status','in','range' => array(0,1)),
			array('access_type','in','range' => array_keys($this->getAccessTypeList())),		
			array('status','in','range' => array_keys($this->getStatusList())),		
			array('title, slug, link, keywords, description, publish_date','filter','filter' => array($obj = new CHtmlPurifier(),'purify')),			
			array('id, blog_id, create_user_id, update_user_id, create_date, update_date, slug, publish_date, title, quote, content, link, status, comment_status, access_type, keywords, description', 'safe', 'on'=>'search'),
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
			'createUser' => array(self::BELONGS_TO, 'User', 'create_user_id'),
			'updateUser' => array(self::BELONGS_TO, 'User', 'update_user_id'),
			'blog' => array(self::BELONGS_TO, 'Blog', 'blog_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('blog','id'),
			'blog_id' => Yii::t('blog','Блог'),
			'create_user_id' => Yii::t('blog','Создал'),
			'update_user_id' => Yii::t('blog','Изменил'),
			'create_date' => Yii::t('blog','Создано'),
			'update_date' => Yii::t('blog','Изменено'),
			'slug' => Yii::t('blog','Урл'),
			'publish_date' => Yii::t('blog','Дата'),
			'title' => Yii::t('blog','Заголовок'),
			'quote' => Yii::t('blog','Цитата'),
			'content' => Yii::t('blog','Содержание'),
			'link' => Yii::t('blog','Ссылка'),
			'status' => Yii::t('blog','Статус'),
			'comment_status' => Yii::t('blog','Комментарии'),
			'access_type' => Yii::t('blog','Доступ'),
			'keywords' => Yii::t('blog','Ключевые слова'),
			'description' => Yii::t('blog','Описание'),
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('blog_id',$this->blog_id,true);
		$criteria->compare('create_user_id',$this->create_user_id,true);
		$criteria->compare('update_user_id',$this->update_user_id,true);
		$criteria->compare('create_date',$this->create_date);
		$criteria->compare('update_date',$this->update_date);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('publish_date',$this->publish_date,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('quote',$this->quote,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('comment_status',$this->comment_status);
		$criteria->compare('access_type',$this->access_type);		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function behaviors()
	{
		return array(
			'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'create_date',
				'updateAttribute' => 'update_date',
			),
			'tags' => array(
				'class'    => 'blog.extensions.taggable.ETaggableBehavior',
				'tagTable' => 'tag',
				'tagBindingTable' => 'post_to_tag',
				'modelTableFk'    => 'post_id',
				'tagBindingTableTagId' => 'tag_id',
				'cacheID' => 'cache',				
			)
		);
    }

    public function beforeSave()
    {
    	if($this->isNewRecord)
    	    $this->create_user_id = $this->update_user_id = Yii::app()->user->getId();
    	
    	$this->update_user_id = Yii::app()->user->getId();
    	
    	return parent::beforeSave();    	
    }

    public function beforeValidate()
    {        
        if (!$this->slug)            
            $this->slug = YText::translit($this->title);                    

        return parent::beforeValidate();        
    }

    public function afterFind()
    {
    	parent::afterFind();

    	$this->create_date = date('d.m.Y H:m',$this->create_date);

    	$this->update_date = date('d.m.Y H:m',$this->update_date);
    }

	public function getStatusList()
	{
		return array(
			self::STATUS_SHEDULED  => Yii::t('blog','По рассписанию'),
			self::STATUS_DRAFT     => Yii::t('blog','Черновик'),
			self::STATUS_PUBLISHED => Yii::t('blog','Опубликовано')
		);
	}

	public function getStatus()
	{
		$data = $this->getStatusList();

		return isset($data[$this->status]) ? $data[$this->status] : Yii::t('blog','*неизвестно*');
	}

	public function getAccessTypeList()
	{
		return array(
			self::ACCESS_PRIVATE => Yii::t('blog','Личный'),
			self::ACCESS_PUBLIC  => Yii::t('blog','Публичный')
		);
	}

	public function getAccessType()
	{
		$data = $this->getAccessTypeList();

		return isset($data[$this->access_type]) ? $data[$this->access_type] : Yii::t('blog','*неизвестно*');
	}

	public function getCommentStatus()
	{
		return $this->comment_status ? Yii::t('blog','Да') : Yii::t('blog','Нет');
	}
}