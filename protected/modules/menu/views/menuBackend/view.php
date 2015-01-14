<?php
/**
 * Файл представления menu/view:
 *
 * @category YupeViews
 * @package  yupe
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://yupe.ru
 *
 **/
$this->breadcrumbs = [
    Yii::t('MenuModule.menu', 'Menu') => ['/menu/menuBackend/index'],
    $model->name,
];

$this->pageTitle = Yii::t('MenuModule.menu', 'Menu - show');

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
            ['label' => Yii::t('MenuModule.menu', 'Menu') . ' «' . $model->name . '»'],
            [
                'icon'  => 'fa fa-fw fa-pencil',
                'label' => Yii::t('MenuModule.menu', 'Change menu'),
                'url'   => ['/menu/menuBackend/update', 'id' => $model->id]
            ],
            [
                'icon'        => 'fa fa-fw fa-eye',
                'encodeLabel' => false,
                'label'       => Yii::t('MenuModule.menu', 'View menu'),
                'url'         => [
                    '/menu/menuBackend/view',
                    'id' => $model->id
                ]
            ],
            [
                'icon'        => 'fa fa-fw fa-trash-o',
                'label'       => Yii::t('MenuModule.menu', 'Remove menu'),
                'url'         => '#',
                'linkOptions' => [
                    'submit'  => ['/menu/menuBackend/delete', 'id' => $model->id],
                    'confirm' => Yii::t('MenuModule.menu', 'Do you really want to delete?'),
                    'params'  => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
                ],
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
        <?php echo Yii::t('MenuModule.menu', 'Show menu'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    [
        'data'       => $model,
        'attributes' => [
            'id',
            'name',
            'code',
            'description',
            [
                'name'  => 'status',
                'value' => $model->getStatus(),
            ],
        ],
    ]
); ?>

<br/>
<div>
    <?php echo Yii::t('MenuModule.menu', 'Use next code for inserting menu in view'); ?>
    <p>
        <?php echo $example; ?>
    </p>
</div>
