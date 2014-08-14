<?php
$this->breadcrumbs = array(
    Yii::t('StoreModule.category', 'Categories') => array('/store/categoryBackend/index'),
    $model->name => array('/store/categoryBackend/view', 'id' => $model->id),
    Yii::t('StoreModule.category', 'Change'),
);

$this->pageTitle = Yii::t('StoreModule.category', 'Categories - edit');

$this->menu = array(
    array('icon' => 'glyphicon glyphicon-list-alt', 'label' => Yii::t('StoreModule.category', 'Category manage'), 'url' => array('/store/categoryBackend/index')),
    array('icon' => 'glyphicon glyphicon-plus-sign', 'label' => Yii::t('StoreModule.category', 'Create category'), 'url' => array('/store/categoryBackend/create')),
    array('label' => Yii::t('StoreModule.category', 'Category') . ' «' . mb_substr($model->name, 0, 32) . '»'),
    array(
        'icon' => 'glyphicon glyphicon-pencil',
        'label' => Yii::t('StoreModule.category', 'Change category'),
        'url' => array(
            '/store/categoryBackend/update',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'glyphicon glyphicon-eye-open',
        'label' => Yii::t('StoreModule.category', 'View category'),
        'url' => array(
            '/store/categoryBackend/view',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'glyphicon glyphicon-trash',
        'label' => Yii::t('StoreModule.category', 'Remove category'),
        'url' => '#',
        'linkOptions' => array(
            'submit' => array('/store/categoryBackend/delete', 'id' => $model->id),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t('StoreModule.category', 'Do you really want to remove category?'),
            'csrf' => true,
        )
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('StoreModule.category', 'Change category'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model, 'languages' => $languages, 'langModels' => $langModels)); ?>
