<?php
$this->breadcrumbs = array(
    Yii::t('MenuModule.menu', 'Menu') => array('/menu/menuBackend/index'),
    Yii::t('MenuModule.menu', 'Menu items'),
);

$this->pageTitle = Yii::t('MenuModule.menu', 'Menu items - remove');

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
        )
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('MenuModule.menu', 'Menu items'); ?>
        <small><?php echo Yii::t('MenuModule.menu', 'manage'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo Yii::t('MenuModule.menu', 'Find menu items'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out search-form">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
    $('.search-form form').submit(function () {
        $.fn.yiiGridView.update('menu-items-grid', {
            data: $(this).serialize()
        });

        return false;
    });
"
    );
    $this->renderPartial('_search', array('model' => $model));
    ?>
</div>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    array(
        'id'                => 'menu-items-grid',
        'sortableRows'      => true,
        'sortableAjaxSave'  => true,
        'sortableAttribute' => 'sort',
        'sortableAction'    => '/menu/menuitemBackend/sortable',
        'dataProvider'      => $model->search(),
        'filter'            => $model,
        'actionsButtons'    => [
            CHtml::link(
                Yii::t('YupeModule.yupe', 'Add'),
                ['/menu/menuitemBackend/create'],
                ['class' => 'btn btn-success pull-right btn-sm']
            )
        ],
        'columns'           => array(
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'title',
                'editable' => array(
                    'url'    => $this->createUrl('/menu/menuitemBackend/inline'),
                    'mode'   => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'title', array('class' => 'form-control')),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'href',
                'editable' => array(
                    'url'    => $this->createUrl('/menu/menuitemBackend/inline'),
                    'mode'   => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'filter'   => CHtml::activeTextField($model, 'href', array('class' => 'form-control')),
            ),
            array(
                'name'   => 'menu_id',
                'value'  => '$data->menu->name',
                'filter' => CHtml::listData(Menu::model()->findAll(), 'id', 'name')
            ),
            array(
                'name'   => 'parent_id',
                'value'  => '$data->getParent()',
                'filter' => CHtml::activeDropDownList(
                    $model,
                    'parent_id',
                    $model->parentTree,
                    array(
                        'disabled' => ($model->menu_id) ? false : true,
                        'encode'   => false,
                        'class'    => 'form-control'
                    )
                ),
            ),
            array(
                'name'   => 'condition_name',
                'value'  => '$data->getConditionName()',
                'filter' => $model->getConditionList(),
            ),
            array(
                'class'   => 'yupe\widgets\EditableStatusColumn',
                'name'    => 'status',
                'url'     => $this->createUrl('/menu/menuitemBackend/inline'),
                'source'  => $model->getStatusList(),
                'options' => [
                    MenuItem::STATUS_ACTIVE   => ['class' => 'label-success'],
                    MenuItem::STATUS_DISABLED => ['class' => 'label-default'],
                ],
            ),
            array(
                'class' => 'yupe\widgets\CustomButtonColumn',
            ),
        ),
    )
); ?>
