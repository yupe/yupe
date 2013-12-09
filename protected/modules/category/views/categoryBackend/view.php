<?php
    $this->breadcrumbs = array(      
        Yii::t('CategoryModule.category', 'Categories') => array('index'),
        $model->name,
    );

    $this->pageTitle = Yii::t('CategoryModule.category', 'Categories - show');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('CategoryModule.category', 'Category manage'), 'url' => array('/category/categoryBackend/index')),
        array('icon' => 'plus-sign', 'label' =>  Yii::t('CategoryModule.category', 'Create category'), 'url' => array('/category/categoryBackend/create')),
        array('label' => Yii::t('CategoryModule.category', 'Category') . ' «' . mb_substr($model->name, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('CategoryModule.category', 'Change category'), 'url' => array(
            '/category/categoryBackend/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('CategoryModule.category', 'View category'), 'url' => array(
            '/category/categoryBackend/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('CategoryModule.category', 'Remove category'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/category/categoryBackend/delete', 'id' => $model->id),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t('CategoryModule.category', 'Do you really want to remove category?'),
            'csrf' => true,
        )),
    );
?>
<div class="page-header">
     <h1>
         <?php echo Yii::t('CategoryModule.category', 'Show category'); ?><br />
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
                ? CHtml::image($model->imageSrc, $model->name, array('width' => 300, 'height' => 300))
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
