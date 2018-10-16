<?php
/**
 * Файл представления menu/index:
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
    Yii::t('MenuModule.menu', 'Manage')
];

$this->pageTitle = Yii::t('MenuModule.menu', 'Menu - manage');

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
        <?php echo Yii::t('MenuModule.menu', 'Menu'); ?>
        <small><?php echo Yii::t('MenuModule.menu', 'manage'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo Yii::t('MenuModule.menu', 'Find menu'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out search-form">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
    $('.search-form form').submit(function () {
        $.fn.yiiGridView.update('menu-grid', {
            data: $(this).serialize()
        });

        return false;
    });"
    );
    $this->renderPartial('_search', ['model' => $model]);
    ?>
</div>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id'           => 'menu-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => [
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'name',
                'editable' => [
                    'url'    => $this->createUrl('/menu/menuBackend/inline'),
                    'mode'   => 'inline',
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'name', ['class' => 'form-control']),
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'code',
                'editable' => [
                    'url'    => $this->createUrl('/menu/menuBackend/inline'),
                    'mode'   => 'inline',
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'code', ['class' => 'form-control']),
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'description',
                'editable' => [
                    'url'        => $this->createUrl('/menu/menuBackend/inline'),
                    'mode'       => 'popup',
                    'type'       => 'textarea',
                    'inputclass' => 'input-large',
                    'title'      => Yii::t(
                        'MenuModule.menu',
                        'Select {field}',
                        ['{field}' => mb_strtolower($model->getAttributeLabel('description'))]
                    ),
                    'params'     => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'description', ['class' => 'form-control']),
            ],
            [
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'status',
                'url'     => $this->createUrl('/menu/menuBackend/inline'),
                'source'  => $model->getStatusList(),
                'options' => [
                    Menu::STATUS_ACTIVE   => ['class' => 'label-success'],
                    Menu::STATUS_DISABLED => ['class' => 'label-default'],
                ],
            ],
            [
                'header' => Yii::t('MenuModule.menu', 'Items'),
                'type'   => 'raw',
                'value'  => 'CHtml::link(count($data->menuItems), Yii::app()->createUrl("/menu/menuitemBackend/index", array("MenuItem[menu_id]" => $data->id)))',
            ],
            [
                'class'    => 'yupe\widgets\CustomButtonColumn',
                'template' => '{view}{update}{delete}{add}',
                'buttons'  => [
                    'add' => [
                        'icon'  => 'fa fa-fw fa-plus-square',
                        'label' => Yii::t('MenuModule.menu', 'Create menu item'),
                        'url'   => 'Yii::app()->createUrl("/menu/menuitemBackend/create", array("mid" => $data->id))',
                    ],
                ],
            ],
        ],
    ]
); ?>
