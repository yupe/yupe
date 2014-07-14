<?php
/**
 * @var ShopOrder $model
 */
$this->breadcrumbs = array(
        Yii::t('ShopModule.shop', 'Orders') => array('/shop/orderBackend/index'),
        Yii::t('ShopModule.shop', 'Order') . ' ' . $model->id,
    );

    $this->menu = array(
        /*array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.shop', 'News management'), 'url' => array('/news/newsBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.shop', 'Create article'), 'url' => array('/news/newsBackend/create')),
        array('label' => Yii::t('ShopModule.shop', 'News Article') . ' «' . mb_substr($model->title, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('ShopModule.shop', 'Edit news article'), 'url' => array(
            '/news/newsBackend/update/',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('ShopModule.shop', 'View news article'), 'url' => array(
            '/news/newsBackend/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('ShopModule.shop', 'Remove news'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/news/newsBackend/delete', 'id' => $model->id),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t('ShopModule.shop', 'Do you really want to remove the article?'),
            'csrf' => true,
        )),*/
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ShopModule.shop', 'Order') . ' ' . $model->id; ?>
        <small>от <?=Yii::app()->dateFormatter->formatDateTime($model->create_time)?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model, )); ?>
