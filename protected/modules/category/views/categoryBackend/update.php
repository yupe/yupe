<?php
$this->breadcrumbs = [
    Yii::t('CategoryModule.category', 'Categories') => ['/category/categoryBackend/index'],
    $model->name                                    => ['/category/categoryBackend/view', 'id' => $model->id],
    Yii::t('CategoryModule.category', 'Change'),
];

$this->pageTitle = Yii::t('CategoryModule.category', 'Categories - edit');

$this->menu = [
    [
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('CategoryModule.category', 'Category manage'),
        'url'   => ['/category/categoryBackend/index']
    ],
    [
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('CategoryModule.category', 'Create category'),
        'url'   => ['/category/categoryBackend/create']
    ],
    ['label' => Yii::t('CategoryModule.category', 'Category') . ' «' . mb_substr($model->name, 0, 32) . '»'],
    [
        'icon'  => 'fa fa-fw fa-pencil',
        'label' => Yii::t('CategoryModule.category', 'Change category'),
        'url'   => [
            '/category/categoryBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon'  => 'fa fa-fw fa-eye',
        'label' => Yii::t('CategoryModule.category', 'View category'),
        'url'   => [
            '/category/categoryBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon'        => 'fa fa-fw fa-trash-o',
        'label'       => Yii::t('CategoryModule.category', 'Remove category'),
        'url'         => '#',
        'linkOptions' => [
            'submit'  => ['/category/categoryBackend/delete', 'id' => $model->id],
            'params'  => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t('CategoryModule.category', 'Do you really want to remove category?'),
            'csrf'    => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CategoryModule.category', 'Editing category'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial(
    '_form',
    ['model' => $model, 'languages' => $languages, 'langModels' => $langModels]
); ?>
