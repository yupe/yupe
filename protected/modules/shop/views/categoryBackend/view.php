<?php
    $this->breadcrumbs = array(      
        Yii::t('ShopModule.category', 'Categories') => array('index'),
        $model->name,
    );

    $this->pageTitle = Yii::t('ShopModule.category', 'Categories - show');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('ShopModule.category', 'Category manage'), 'url' => array('/shop/categoryBackend/index')),
        array('icon' => 'plus-sign', 'label' =>  Yii::t('ShopModule.category', 'Create category'), 'url' => array('/shop/categoryBackend/create')),
        array('label' => Yii::t('ShopModule.category', 'Category') . ' «' . mb_substr($model->name, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('ShopModule.category', 'Change category'), 'url' => array(
            '/shop/categoryBackend/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('ShopModule.category', 'View category'), 'url' => array(
            '/shop/categoryBackend/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('ShopModule.category', 'Remove category'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/shop/categoryBackend/delete', 'id' => $model->id),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t('ShopModule.category', 'Do you really want to remove category?'),
            'csrf' => true,
        )),
    );
?>
<div class="page-header">
     <h1>
         <?php echo Yii::t('ShopModule.category', 'Show category'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
     </h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data'       => $model,
    'attributes' => array(
        'id',
        array(
            'name'  => 'parent_id',
            'value' => $model->getParentName(),
        ),
        'name',
        'alias',
        array(
            'name'  => 'image',
            'type'  => 'raw',
            'value' => $model->image
                ? CHtml::image($model->getImageUrl(200, 200), $model->name)
                : '---',
        ),
        array(
            'name' => 'description',
            'type' => 'raw'
        ),
        array(
            'name' => 'short_description',
            'type' => 'raw'
        ),
        array(
            'name'  => 'status',
            'value' => $model->getStatus(),
        ),
    ),
)); ?>
