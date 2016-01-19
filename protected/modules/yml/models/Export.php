<?php

/**
 *
 * @property integer $id
 * @property string $name
 * @property string $settings
 *
 */
class Export extends \yupe\models\YModel
{
    /**
     * @var array
     */
    public $brands = [];

    /**
     * @var array
     */
    public $categories = [];

    /**
     * @var
     */
    public $shop_name;
    /**
     * @var
     */
    public $shop_company;
    /**
     * @var
     */
    public $shop_url;
    /**
     * @var
     */
    public $shop_platform;
    /**
     * @var
     */
    public $shop_version;
    /**
     * @var
     */
    public $shop_agency;
    /**
     * @var
     */
    public $shop_email;
    /**
     * @var
     */
    public $shop_cpa;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{yml_export}}';
    }

    /**
     * @param null|string $className
     * @return $this
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['name, shop_name, shop_company, shop_url', 'required'],
            ['name', 'unique'],
            ['name', 'length', 'max' => 255],
            ['shop_name', 'length', 'max' => 20],
            ['shop_platform', 'default', 'value' => 'Yupe!'],
            ['shop_url, shop_platform, shop_version, shop_agency, shop_email, shop_cpa', 'length', 'max' => 255],
            ['brands, categories', 'safe'],
            ['id, name, settings', 'safe', 'on' => 'search'],
        ];
    }


    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('YmlModule.default', 'Id'),
            'name' => Yii::t('YmlModule.default', 'Title'),
            'settings' => Yii::t('YmlModule.default', 'Settings'),
            'brands' => Yii::t('YmlModule.default', 'Brands'),
            'categories' => Yii::t('YmlModule.default', 'Categories'),
            'shop_name' => Yii::t('YmlModule.default', 'Store short title'),
            'shop_company' => Yii::t('YmlModule.default', 'Company name'),
            'shop_url' => Yii::t('YmlModule.default', 'Store URL'),
            'shop_platform' => Yii::t('YmlModule.default', 'Store CMS'),
            'shop_version' => Yii::t('YmlModule.default', 'CMS version'),
            'shop_agency' => Yii::t(
                'YmlModule.default',
                'The name of the Agency which provides technical support to the online store and is responsible for the performance of the website'
            ),
            'shop_email' => Yii::t(
                'YmlModule.default',
                'Contact the developers of CMS or tech support agency'
            ),
            'shop_cpa' => Yii::t('YmlModule.default', 'To participate in the "Buy at Market" program'),
        ];
    }


    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider(
            $this, [
                'criteria' => $criteria,
            ]
        );
    }

    /**
     *
     */
    public function afterFind()
    {
        $settings = json_decode($this->settings);
        $this->brands = $settings->brands;
        $this->categories = $settings->categories;
        $this->shop_name = $settings->shop_name;
        $this->shop_company = $settings->shop_company;
        $this->shop_url = $settings->shop_url;
        $this->shop_platform = $settings->shop_platform;
        $this->shop_version = $settings->shop_version;
        $this->shop_agency = $settings->shop_agency;
        $this->shop_email = $settings->shop_email;
        $this->shop_cpa = $settings->shop_cpa;
        parent::afterFind();
    }


    /**
     * @return bool
     */
    public function beforeValidate()
    {
        $settings = [
            'brands' => $this->brands,
            'categories' => $this->categories,
            'shop_name' => $this->shop_name,
            'shop_company' => $this->shop_company,
            'shop_url' => $this->shop_url,
            'shop_platform' => $this->shop_platform,
            'shop_version' => $this->shop_version,
            'shop_agency' => $this->shop_agency,
            'shop_email' => $this->shop_email,
            'shop_cpa' => $this->shop_cpa,
        ];
        $this->settings = json_encode($settings);

        return parent::beforeValidate();
    }
}
