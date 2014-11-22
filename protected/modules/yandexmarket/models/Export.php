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
     * @var array Массив id брендов, которые будут выведены
     */
    public $brands = [];

    /**
     * @var array
     */
    public $categories = [];

    public $shop_name;
    public $shop_company;
    public $shop_url;
    public $shop_platform;
    public $shop_version;
    public $shop_agency;
    public $shop_email;
    public $shop_cpa;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{yandex_market_export}}';
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
            'id' => Yii::t('YandexMarketModule.default', 'Id'),
            'name' => Yii::t('YandexMarketModule.default', 'Название выгрузки'),
            'settings' => Yii::t('YandexMarketModule.default', 'Settings'),
            'brands' => Yii::t('YandexMarketModule.default', 'Бренды'),
            'categories' => Yii::t('YandexMarketModule.default', 'Categories'),
            'shop_name' => Yii::t('YandexMarketModule.default', 'Короткое название магазина'),
            'shop_company' => Yii::t('YandexMarketModule.default', 'Полное наименование компании, владеющей магазином'),
            'shop_url' => Yii::t('YandexMarketModule.default', 'URL-адрес главной страницы магазина'),
            'shop_platform' => Yii::t('YandexMarketModule.default', 'Система управления контентом, на основе которой работает магазин (CMS)'),
            'shop_version' => Yii::t('YandexMarketModule.default', 'Версия CMS'),
            'shop_agency' => Yii::t('YandexMarketModule.default', 'Наименование агентства, которое оказывает техническую поддержку интернет-магазину и отвечает за работоспособность сайта'),
            'shop_email' => Yii::t('YandexMarketModule.default', 'Контактный адрес разработчиков CMS или агентства, осуществляющего техподдержку'),
            'shop_cpa' => Yii::t('YandexMarketModule.default', 'Участие товарных предложений в программе «Покупка на Маркете»'),
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
