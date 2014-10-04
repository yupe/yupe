<?php

/**
 * @property integer $id
 * @property string $module
 * @property string $model
 * @property string $changefreq
 * @property float $priority
 * @property integer $status
 *
 * @method SitemapModel active()
 */
class SitemapModel extends yupe\models\YModel
{
    const STATUS_ACTIVE = 1;
    const STATUS_NOT_ACTIVE = 0;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return '{{sitemap_model}}';
    }

    public function rules()
    {
        return [
            ['module, model, changefreq', 'length', 'max' => 20],
            ['priority', 'numerical'],
            ['status', 'numerical', 'integerOnly' => true],
            ['id, module, model, changefreq, priority, status', 'safe', 'on' => 'search'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('SitemapModule.sitemap', 'Id'),
            'module' => Yii::t('SitemapModule.sitemap', 'Module'),
            'model' => Yii::t('SitemapModule.sitemap', 'Model'),
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
        $criteria->compare('module', $this->module, true);
        $criteria->compare('model', $this->model, true);
        $criteria->compare('changefreq', $this->changefreq, true);
        $criteria->compare('priority', $this->priority);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider(
            get_class($this), [
                'criteria' => $criteria,
                'sort' => ['defaultOrder' => 'module ASC, model ASC'],
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
