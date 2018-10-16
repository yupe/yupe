<?php
$this->breadcrumbs = [
    Yii::t('MenuModule.menu', 'Menu')       => ['/menu/menuBackend/index'],
    Yii::t('MenuModule.menu', 'Menu items') => ['/menu/menuitemBackend/index'],
    Yii::t('MenuModule.menu', 'Create'),
];

$this->pageTitle = Yii::t('MenuModule.menu', 'Menu items - create');

$this->menu = [
    [
        'label' => Yii::t('MenuModule.menu', 'Menu'),
        'items' => [
            [
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('MenuModule.menu', 'Manage menu'),
                'url'   => ['/menu/menuBackend/index']
            ],
            [
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('MenuModule.menu', 'Create menu'),
                'url'   => ['/menu/menuBackend/create']
            ],
        ]
    ],
    [
        'label' => Yii::t('MenuModule.menu', 'Menu items'),
        'items' => [
            [
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('MenuModule.menu', 'Manage menu items'),
                'url'   => ['/menu/menuitemBackend/index']
            ],
            [
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('MenuModule.menu', 'Create menu item'),
                'url'   => ['/menu/menuitemBackend/create']
            ],
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('MenuModule.menu', 'Menu item'); ?>
        <small><?php echo Yii::t('MenuModule.menu', 'create'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>
