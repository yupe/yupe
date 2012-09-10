<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('catalog')->getCategory() => array(),
        Yii::t('catalog', 'Товары') => array('/catalog/default/index'),
        $model->name,
    );
    $this->pageTitle = Yii::t('catalog', 'Товары - просмотр');
    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('catalog', 'Управление товарами'), 'url' => array('/catalog/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('catalog', 'Добавить товар'), 'url' => array('/catalog/default/create')),
        array('label' => Yii::t('catalog', 'Товар')),
        array('icon' => 'pencil', 'encodeLabel' => false, 'label' => Yii::t('catalog', 'Редактирование товара'), 'url' => array(
            '/catalog/default/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open white', 'encodeLabel' => false, 'label' => Yii::t('catalog', 'Просмотреть товар'), 'url' => array(
            '/catalog/default/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('catalog', 'Удалить товар'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('delete', 'id' => $model->id),
            'confirm' => Yii::t('catalog', 'Вы уверены, что хотите удалить товар?')
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('catalog', 'Просмотр') . ' ' . Yii::t('catalog', 'товара'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data'       => $model,
    'attributes' => array(
        'id',
        'category_id',
        'name',
        'price',
        'article',
        'image',
        'short_description',
        'description',
        'alias',
        'data',
        'is_special',
        'status',
        'create_time',
        'update_time',
        'user_id',
        'change_user_id',
    ),
)); ?>
