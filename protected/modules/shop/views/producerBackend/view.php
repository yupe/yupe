<?php
/* @var $model Producer */
$this->breadcrumbs = array(
    Yii::t('ShopModule.producer', 'Производители') => array('/shop/producerBackend/index'),
    $model->name,
);

$this->pageTitle = Yii::t('ShopModule.producer', 'Производители - просмотр');

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.producer', 'Управление производителями'), 'url' => array('/shop/producerBackend/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('ShopModule.producer', 'Добавить производителя'), 'url' => array('/shop/producerBackend/create')),
    array('label' => Yii::t('ShopModule.producer', 'Производитель') . ' «' . mb_substr($model->name_short, 0, 32) . '»'),
    array('icon' => 'pencil', 'label' => Yii::t('ShopModule.producer', 'Редактирование производителя'), 'url' => array(
        '/shop/producerBackend/update',
        'id' => $model->id
    )),
    array('icon' => 'eye-open', 'label' => Yii::t('ShopModule.producer', 'Просмотреть производителя'), 'url' => array(
        '/shop/producerBackend/view',
        'id' => $model->id
    )),
    array('icon' => 'trash', 'label' => Yii::t('ShopModule.producer', 'Удалить производителя'), 'url' => '#', 'linkOptions' => array(
        'submit'  => array('/shop/producerBackend/delete', 'id' => $model->id),
        'confirm' => Yii::t('ShopModule.producer', 'Вы уверены, что хотите удалить производителя?'),
        'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
        'csrf' => true,
    )),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ShopModule.producer', 'Просмотр') . ' ' . Yii::t('ShopModule.producer', 'производителя'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data'       => $model,
    'attributes' => array(
        'id',
        'name_short',
        'name',
        'slug',
        array(
            'name' => 'status',
            'value' => $model->statusTitle,
        ),
        'order',
        array(
            'name'  => 'image',
            'type'  => 'raw',
            'value' => CHtml::image($model->getImageUrl()),
        ),
        array(
            'name' => 'short_description',
            'type' => 'html'
        ),
        array(
            'name' => 'description',
            'type' => 'html'
        ),
        'meta_title',
        'meta_keywords',
        'meta_description'
    ),
)); ?>
