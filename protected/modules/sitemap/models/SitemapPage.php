<?php

/**
 * @property integer $id
 * @property string $url
 * @property string $changefreq
 * @property float $priority
 * @property integer $status
 *
 * @method SitemapPage active()
 */
class SitemapPage extends yupe\models\YModel
{
    const STATUS_ACTIVE = 1;
    const STATUS_NOT_ACTIVE = 0;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{sitemap_page}}';
    }

    public function rules()
    {
        return [
            ['url', 'required'],
            ['url', 'unique'],
            ['url', 'length', 'max' => 250],
            ['changefreq', 'length', 'max' => 20],
            ['priority', 'numerical'],
            ['status', 'numerical', 'integerOnly' => true],
            ['id, url, changefreq, priority, status', 'safe', 'on' => 'search'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('SitemapModule.sitemap', 'Id'),
            'url' => Yii::t('SitemapModule.sitemap', 'Url'),
            'changefreq' => Yii::t('SitemapModule.sitemap', 'Change frequency'),
            'priority' => Yii::t('SitemapModule.sitemap', 'Priority'),
            'status' => Yii::t('SitemapModule.sitemap', 'Status'),
        ];
    }

    public function scopes()
    {
        return [
            'active' => [
                'condition' => 'status = :status',
                'params' => ['status' => self::STATUS_ACTIVE],
            ],
        ];
    }

    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id);
        $criteria->compare('module', $this->url, true);
        $criteria->compare('changefreq', $this->changefreq, true);
        $criteria->compare('priority', $this->priority);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider(
            get_class($this), [
                'criteria' => $criteria,
                'sort' => ['defaultOrder' => 'url ASC'],
            ]
        );
    }

    public function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => Yii::t('SitemapModule.sitemap', 'Enabled'),
            self::STATUS_NOT_ACTIVE => Yii::t('SitemapModule.sitemap', 'Disabled'),
        ];
    }

    public function getStatus()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('SitemapModule.sitemap', '*unknown*');
    }
}
