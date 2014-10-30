<?php
$this->breadcrumbs = array(
    Yii::t('MenuModule.menu', 'Menu')       => array('/menu/menuBackend/index'),
    Yii::t('MenuModule.menu', 'Menu items') => array('/menu/menuitemBackend/index'),
    $model->title,
);

$this->pageTitle = Yii::t('MenuModule.menu', 'Menu items - show');

$this->menu = array(
    array(
        'label' => Yii::t('MenuModule.menu', 'Menu'),
        'items' => array(
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('MenuModule.menu', 'Manage menu'),
                'url'   => array('/menu/menuBackend/index')
            ),
            array(
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('MenuModule.menu', 'Create menu'),
                'url'   => array('/menu/menuBackend/create')
            ),
        )
    ),
    array(
        'label' => Yii::t('MenuModule.menu', 'Menu items'),
        'items' => array(
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('MenuModule.menu', 'Manage menu items'),
                'url'   => array('/menu/menuitemBackend/index')
            ),
            array(
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('MenuModule.menu', 'Create menu item'),
                'url'   => array('/menu/menuitemBackend/create')
            ),
            array('label' => Yii::t('MenuModule.menu', 'Menu item') . ' «' . $model->title . '»'),
            array(
                'icon'  => 'fa fa-fw fa-pencil',
                'label' => Yii::t('MenuModule.menu', 'Change menu item'),
                'url'   => array('/menu/menuitemBackend/update', 'id' => $model->id)
            ),
            array(
                'icon'        => 'fa fa-fw fa-eye',
                'encodeLabel' => false,
                'label'       => Yii::t('MenuModule.menu', 'View menu item'),
                'url'         => array(
                    '/menu/menuitemBackend/view',
                    'id' => $model->id
                )
            ),
            array(
                'icon'        => 'fa fa-fw fa-trash-o',
                'label'       => Yii::t('MenuModule.menu', 'Remove menu item'),
                'url'         => '#',
                'linkOptions' => array(
                    'submit'  => array('/menu/menuitemBackend/delete', 'id' => $model->id),
                    'confirm' => Yii::t('MenuModule.menu', 'Do you really want to delete?'),
                    'params'  => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
                ),
            ),
        )
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('MenuModule.menu', 'Show menu item'); ?><br/>
        <small>&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    array(
        'data'       => $model,
        'attributes' => array(
            'id',
            'title',
            'href',
            'class',
            'title_attr',
            'before_link',
            'after_link',
            'target',
            'rel',
            array(
                'name'  => 'menu_id',
                'value' => $model->menu->name,
            ),
            array(
                'name'  => 'parent_id',
                'value' => $model->parent,
            ),
            array(
                'name'  => 'condition_name',
                'value' => $model->conditionName,
            ),
            'sort',
            array(
                'name'  => 'status',
                'value' => $model->getStatus(),
            ),
        ),
    )
); ?>
