<?php
/**
 * This is the model class for table "wiki_link" that stores information
 * about links between wiki pages.
 *
 * The followings are the available columns in table 'wiki_link':
 * @property integer $id
 * @property integer $page_from_id
 * @property integer $page_to_id
 * @property string $wiki_uid
 * @property string $title
 *
 * The followings are the available model relations:
 * @property WikiPage $page_from
 * @property WikiPage $page_to
 */
class WikiLink extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return WikiLink the static model class
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
		return 'wiki_link';
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
			'page_from' => array(self::BELONGS_TO, 'WikiPage', 'page_from_id'),
			'page_to' => array(self::BELONGS_TO, 'WikiPage', 'page_to_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
		);
	}

	/**
	 * Find link by unique wiki id
	 *
	 * @param string $uid unique wiki id
	 * @return WikiLink
	 */
	public function findByWikiUid($uid)
	{
		return self::model()->findByAttributes(array(
			'wiki_uid' => $uid,
		));
	}
}