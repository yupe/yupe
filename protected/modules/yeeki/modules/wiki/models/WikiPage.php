<?php
/**
 * This is the model class for table "wiki_page" that stores wiki pages.
 *
 * The followings are the available columns in table 'wiki_page':
 * @property integer $id
 * @property integer $is_redirect
 * @property string $page_uid
 * @property string $content
 * @property string $namespace
 * @property integer $revision_id
 * @property string $user_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * The followings are the available model relations:
 * @property WikiLink[] $links
 * @property WikiPageRevision[] $revisions
 */
class WikiPage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return WikiPage the static model class
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
		return 'wiki_page';
	}

	public function behaviors()
	{
		return array(
			'CTimestampBehavior'=>array(
				'class'=>'zii.behaviors.CTimestampBehavior',
				'createAttribute'=>'created_at',
				'updateAttribute'=>'updated_at',
				'setUpdateOnCreate'=>true,
			)
		);
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			//array('is_redirect', 'numerical', 'integerOnly'=>true),
			array('content', 'safe'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'links' => array(self::HAS_MANY, 'WikiLink', 'page_id'),
			'revisions' => array(self::HAS_MANY, 'WikiPageRevision', 'page_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'is_redirect' => 'Is Redirect',
			'wiki_uid' => 'PageID',
			'namespace' => 'Namespace',
			'content' => 'Content',
			'revision_id' => 'Revision',
		);
	}

	/**
	 * @param string $uid unique wiki id
	 */
	public function setWikiUid($uid)
	{
		$parts = $this->getPartsFromWikiUid($uid);
		$this->page_uid = $parts['page_uid'];
		$this->namespace = $parts['namespace'];
	}

	/**
	 * @return string unique wiki id
	 */
	public function getWikiUid()
	{
		if($this->namespace)
		{
			$parts[] = $this->namespace.':';
		}

		$parts[] = $this->page_uid;
		return implode('', $parts);
	}

	/**
	 * @param string $uid unique wiki id
	 * @return array array containing namespace and pageid
	 */
	private function getPartsFromWikiUid($uid)
	{
		$parts = explode(':', $uid);
		$first = array_shift($parts);

		if(!count($parts))
		{
			return array(
				'namespace' => null,
				'page_uid' => $first,
			);
		}
		else
		{
			return array(
				'namespace' => $first,
				'page_uid' => implode('', $parts),
			);
		}
	}

	/**
	 * Find page by unique wiki id
	 *
	 * @param string $uid
	 * @return WikiPage
	 */
	public function findByWikiUid($uid)
	{
		$parts = $this->getPartsFromWikiUid($uid);

		$criteria = new CDbCriteria();
		$criteria->compare('page_uid', $parts['page_uid']);
		$criteria->compare('namespace', $parts['namespace']);

		return self::model()->find($criteria);
	}

	/**
	 * @return string wiki page text cache key
	 */
	public function getCacheKey()
	{
		return 'wiki_page_'.$this->id;
	}
}