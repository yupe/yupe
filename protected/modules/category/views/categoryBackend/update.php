<?php
$this->breadcrumbs = array(
    Yii::t('CategoryModule.category', 'Categories') => array('/category/categoryBackend/index'),
    $model->name                                    => array('/category/categoryBackend/view', 'id' => $model->id),
    Yii::t('CategoryModule.category', 'Change'),
);

$this->pageTitle = Yii::t('CategoryModule.category', 'Categories - edit');

$this->menu = array(
    array(
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('CategoryModule.category', 'Category manage'),
        'url'   => array('/category/categoryBackend/index')
    ),
    array(
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('CategoryModule.category', 'Create category'),
        'url'   => array('/category/categoryBackend/create')
    ),
    array('label' => Yii::t('CategoryModule.category', 'Category') . ' «' . mb_substr($model->name, 0, 32) . '»'),
    array(
        'icon'  => 'fa fa-fw fa-pencil',
        'label' => Yii::t('CategoryModule.category', 'Change category'),
        'url'   => array(
            '/category/categoryBackend/update',
            'id' => $model->id
        )
    ),
    array(
        'icon'  => 'fa fa-fw fa-eye',
        'label' => Yii::t('CategoryModule.category', 'View category'),
        'url'   => array(
            '/category/categoryBackend/view',
            'id' => $model->id
        )
    ),
    array(
        'icon'        => 'fa fa-fw fa-trash-o',
        'label'       => Yii::t('CategoryModule.category', 'Remove category'),
        'url'         => '#',
        'linkOptions' => array(
            'submit'  => array('/category/categoryBackend/delete', 'id' => $model->id),
            'params'  => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t('CategoryModule.category', 'Do you really want to remove category?'),
            'csrf'    => true,
        )
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CategoryModule.category', 'Change category'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial(
    '_form',
    array('model' => $model, 'languages' => $languages, 'langModels' => $langModels)
); ?>
