<?php
$this->breadcrumbs = array(
    Yii::t('StoreModule.store', 'Categories') => array('/store/categoryBackend/index'),
    $model->name => array('/store/categoryBackend/view', 'id' => $model->id),
    Yii::t('StoreModule.store', 'Change'),
);

$this->pageTitle = Yii::t('StoreModule.store', 'Categories - edit');

$this->menu = array(
    array('icon' => 'fa fa-fw fa-list-alt', 'label' => Yii::t('StoreModule.store', 'Category manage'), 'url' => array('/store/categoryBackend/index')),
    array('icon' => 'fa fa-fw fa-plus-square', 'label' => Yii::t('StoreModule.store', 'Create category'), 'url' => array('/store/categoryBackend/create')),
    array('label' => Yii::t('StoreModule.store', 'Category') . ' «' . mb_substr($model->name, 0, 32) . '»'),
    array(
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('StoreModule.store', 'Change category'),
        'url' => array(
            '/store/categoryBackend/update',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('StoreModule.store', 'View category'),
        'url' => array(
            '/store/categoryBackend/view',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('StoreModule.store', 'Remove category'),
        'url' => '#',
        'linkOptions' => array(
            'submit' => array('/store/categoryBackend/delete', 'id' => $model->id),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t('StoreModule.store', 'Do you really want to remove category?'),
            'csrf' => true,
        )
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.store', 'Change category'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
