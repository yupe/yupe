<?php

/**
 * This is the model class for table "wiki_page_revision" that stores wiki page
 * revisions.
 *
 * The followings are the available columns in table 'wiki_page_revision':
 * @property integer $id
 * @property integer $page_id
 * @property string $comment
 * @property integer $is_minor
 * @property string $content
 * @property string $user_id
 * @property integer $created_at
 *
 * The followings are the available model relations:
 * @property WikiPage $page
 */
class WikiPageRevision extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return WikiPageRevision the static model class
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
		return 'wiki_page_revision';
	}

	public function behaviors()
	{
		return array(
			'CTimestampBehavior'=>array(
				'class'=>'zii.behaviors.CTimestampBehavior',
				'createAttribute'=>'created_at',
				'updateAttribute'=>false,
			)
		);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array();
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'page' => array(self::BELONGS_TO, 'WikiPage', 'page_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'page_id' => 'Page',
			'comment' => 'Comment',
			'is_minor' => 'Is Minor',
			'content' => 'Content',
		);
	}

	/**
	 * @return string wiki revision text cache key
	 */
	public function getCacheKey()
	{
		return 'wiki_page_'.$this->page_id.'_rev_'.$this->id;
	}
}