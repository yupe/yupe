<?php
/* @var $model Producer */
$this->breadcrumbs = array(
    Yii::t('StoreModule.producer', 'Производители') => array('/store/producerBackend/index'),
    $model->name,
);

$this->pageTitle = Yii::t('StoreModule.producer', 'Производители - просмотр');

$this->menu = array(
    array('icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.producer', 'Управление производителями'), 'url' => array('/store/producerBackend/index')),
    array('icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.producer', 'Добавить производителя'), 'url' => array('/store/producerBackend/create')),
    array('label' => Yii::t('StoreModule.producer', 'Производитель') . ' «' . mb_substr($model->name_short, 0, 32) . '»'),
    array(
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('StoreModule.producer', 'Редактирование производителя'),
        'url' => array(
            '/store/producerBackend/update',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('StoreModule.producer', 'Просмотреть производителя'),
        'url' => array(
            '/store/producerBackend/view',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('StoreModule.producer', 'Удалить производителя'),
        'url' => '#',
        'linkOptions' => array(
            'submit' => array('/store/producerBackend/delete', 'id' => $model->id),
            'confirm' => Yii::t('StoreModule.producer', 'Вы уверены, что хотите удалить производителя?'),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'csrf' => true,
        )
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.producer', 'Просмотр') . ' ' . Yii::t('StoreModule.producer', 'производителя'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    array(
        'data' => $model,
        'attributes' => array(
            'id',
            'name_short',
            'name',
            'slug',
            array(
                'name' => 'status',
                'value' => $model->getStatusTitle(),
            ),
            'order',
            array(
                'name' => 'image',
                'type' => 'raw',
                'value' => function($model){
                        return $model->image ? CHtml::image($model->getImageUrl()) : '';
                    },
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
    )
); ?>
