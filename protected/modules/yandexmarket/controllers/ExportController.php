<?php

/**
 * Class ExportController
 *
 */
class ExportController extends application\components\Controller
{
    public $cacheKey = 'yandexmarket::export::';

    public function actionView($id)
    {
        /* @var $model Export */
        $model = Export::model()->findByPk($id);

        if (!$model) {
            throw new CHttpException(404);
        }

        $cacheKey = $this->cacheKey . $model->id;

        if (!($xml = Yii::app()->getCache()->get($cacheKey))) {

            $xml = $this->getXmlHead();
            $xml .= CHtml::openTag('yml_catalog', ['date' => date('Y-m-d H:i')]);
            $xml .= CHtml::openTag('shop');

            $xml .= $this->getShopInfo(
                $model->shop_name,
                $model->shop_company,
                $model->shop_url ? : Yii::app()->getBaseUrl(true),
                $model->shop_platform,
                $model->shop_version,
                $model->shop_agency,
                $model->shop_email,
                $model->shop_cpa
            );

            $xml .= $this->getCurrenciesElement([['id' => 'RUR', 'rate' => 1]]);

            $xml .= $this->getCategoriesElement();

            $xml .= $this->getOffersElement($model->categories, $model->brands);

            $xml .= CHtml::closeTag('shop');
            $xml .= CHtml::closeTag('yml_catalog');
            Yii::app()->getCache()->set($cacheKey, $xml, 60 * 60);
        }
        header("Content-type: text/xml");
        echo $xml;
        Yii::app()->end();
    }

    private function getXmlHead()
    {
        return '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL . '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">' . PHP_EOL;
    }

    /**
     * @param string $name Короткое название магазина (название, которое выводится в списке найденных на Яндекс.Маркете товаров).
     *      Не должно содержать более 20 символов. Нельзя использовать слова, не имеющие отношения к наименованию магазина ("лучший", "дешевый"),
     *      указывать номер телефона и т.п. Название магазина, должно совпадать с фактическим названием магазина, которое публикуется на сайте.
     *      При несоблюдении данного требования наименование может быть изменено Яндексом самостоятельно без уведомления Клиента.
     * @param string $company Полное наименование компании, владеющей магазином.
     * @param string $url URL-адрес главной страницы магазина.
     * @param string|null $platform Система управления контентом, на основе которой работает магазин (CMS).
     * @param string|null $version Версия CMS.
     * @param string|null $agency Наименование агентства, которое оказывает техническую поддержку интернет-магазину и отвечает за работоспособность сайта.
     * @param string|null $email Контактный адрес разработчиков CMS или агентства, осуществляющего техподдержку.
     * @param int|null $cpa Элемент предназначен для управления участием товарных предложений в программе «Покупка на Маркете».
     *
     * @return string
     */
    private function getShopInfo(
        $name,
        $company,
        $url,
        $platform = null,
        $version = null,
        $agency = null,
        $email = null,
        $cpa = null
    ) {
        $res = '';
        $res .= CHtml::tag('name', [], $name);
        $res .= CHtml::tag('company', [], $company);
        $res .= CHtml::tag('url', [], $url);
        $res .= $platform ? CHtml::tag('platform', [], $platform) : '';
        $res .= $version ? CHtml::tag('version', [], $version) : '';
        $res .= $agency ? CHtml::tag('agency', [], $agency) : '';
        $res .= $email ? CHtml::tag('email', [], $email) : '';

        //$res .= $cpa ? CHtml::tag('cpa', [], $cpa) : '';

        return $res;
    }

    /**
     * @param array $currencies Массив валют в формате
     * [
     *  ['id' => 'RUR', 'rate' => 1],
     *  ...
     * ]
     * @return string
     */
    private function getCurrenciesElement($currencies)
    {
        $res = '';
        $res .= CHtml::openTag('currencies');
        foreach ($currencies as $currency) {
            $res .= CHtml::tag('currency', ['id' => $currency['id'], 'rate' => $currency['rate']]);
        }
        $res .= CHtml::closeTag('currencies');

        return $res;
    }

    private function getCategoriesElement()
    {
        $models = StoreCategory::model()->published()->findAll();
        $res = null;
        $res .= CHtml::openTag('categories');

        /* @var $models StoreCategory[] */
        foreach ($models as $model) {
            $res .= CHtml::tag('category', ['id' => $model->id, 'parentId' => $model->parent_id], $model->name);
        }

        $res .= CHtml::closeTag('categories');

        return $res;
    }

    private function getOffersElement($categories, $brands)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('t.status', Product::STATUS_ACTIVE);
        $categories = (array)$categories;
        $brands = (array)$brands;

        if (!empty($categories)) {
            $criteria->addInCondition('t.category_id', (array)$categories);
        }

        if (!empty($brands)) {
            $criteria->addInCondition('t.producer_id', (array)$brands);
        }

        $dataProvider = new CActiveDataProvider('Product', ['criteria' => $criteria]);
        $iterator = new CDataProviderIterator($dataProvider, 100);

        $res = '';
        $res .= CHtml::openTag('offers');
        /* @var $model Product */
        foreach ($iterator as $model) {
            //пропускам товар без производителя
            if(empty($model->producer)) {
                continue;
            }
            $res .= CHtml::openTag(
                'offer',
                ['id' => $model->id, 'type' => 'vendor.model', 'available' => ($model->in_stock ? 'true' : 'false')]
            );
            $res .= $this->getOfferInfo($model);

            $res .= CHtml::closeTag('offer');
        }

        $res .= CHtml::closeTag('offers');

        return $res;
    }

    private function getOfferInfo(Product $model)
    {
        $res = '';
        $res .= CHtml::tag('url', [], $model->getUrl(true));
        $res .= CHtml::tag('price', [], $model->price);
        $res .= CHtml::tag('currencyId', [], 'RUR');
        $res .= CHtml::tag('categoryId', [], $model->category_id);
        // tag market_category
        $imageCount = 0;
        if ($model->image) {
            $res .= CHtml::tag('picture', [], $model->getImageUrl());
            $imageCount++;
        }

        foreach ($model->getImages() as $image) {
            if ($imageCount > 10) {
                break;
            }
            $res .= CHtml::tag('picture', [], $image->getImageUrl());
            $imageCount++;
        }

        // tag store
        // tag pickup
        // tag delivery
        // tag local_delivery_cost
        // tag typePrefix

        $res .= CHtml::tag('vendor', [], $model->producer->name);

        // tag vendorCode

        $res .= CHtml::tag('model', [], htmlspecialchars(strip_tags($model->name)));
        $res .= CHtml::tag('description', [], htmlspecialchars(strip_tags($model->description)));

        // tag sales_notes
        // tag manufacturer_warranty
        // tag seller_warranty
        // tag country_of_origin
        // tag downloadable
        // tag adult
        // tag age
        // tag barcode
        // tag cpa
        // tag rec
        // tag expiry
        // tag weight
        // tag dimensions
        // tag param

        return $res;
    }
}
