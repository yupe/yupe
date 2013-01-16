<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('catalog')->getCategory() => array(),
        Yii::t('CatalogModule.catalog', 'Товары') => array('/catalog/defaultAdmin/index'),
        $model->name,
    );

    $this->pageTitle = Yii::t('CatalogModule.catalog', 'Товары - просмотр');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('CatalogModule.catalog', 'Управление товарами'), 'url' => array('/catalog/defaultAdmin/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('CatalogModule.catalog', 'Добавить товар'), 'url' => array('/catalog/defaultAdmin/create')),
        array('label' => Yii::t('CatalogModule.catalog', 'Товар') . ' «' . mb_substr($model->name, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('CatalogModule.catalog', 'Редактирование товара'), 'url' => array(
            '/catalog/defaultAdmin/update',
        	'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('CatalogModule.catalog', 'Просмотреть товар'), 'url' => array(
            '/catalog/defaultAdmin/view', 
        	'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('CatalogModule.catalog', 'Удалить товар'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/catalog/defaultAdmin/delete', 'id' => $model->id),
            'confirm' => Yii::t('CatalogModule.catalog', 'Вы уверены, что хотите удалить товар?')
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CatalogModule.catalog', 'Просмотр товара'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data'       => $model,
    'attributes' => array(
        'id',
        array(
            'name'  => 'category_id',
            'value' => $model->category->name,
        ),
        'name',
        'price',
        'article',
        'image',
        'short_description',
        'description',
        'alias',
        'data',
        array(
            'name'  => 'is_special',
            'value' => $model->getSpecial(),
        ),
        array(
            'name'  => 'status',
            'value' => $model->getStatus(),
        ),
        array(
            'name'  => 'user_id',
            'value' => $model->user->getFullName(),
        ),
        array(
            'name'  => 'change_user_id',
            'value' => $model->changeUser->getFullName(),
        ),
        array(
            'name'  => 'create_time',
            'value' => Yii::app()->getDateFormatter()->formatDateTime($model->create_time, "short", "short"),
        ),
        array(
            'name'  => 'update_time',
            'value' => Yii::app()->getDateFormatter()->formatDateTime($model->update_time, "short", "short"),
        ),
    ),
)); ?>