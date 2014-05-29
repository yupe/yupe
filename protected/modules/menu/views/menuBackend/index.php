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
$this->breadcrumbs = array(   
    Yii::t('MenuModule.menu', 'Menu') => array('/menu/menuBackend/index'),
    Yii::t('MenuModule.menu', 'Manage')
);

$this->pageTitle = Yii::t('MenuModule.menu', 'Menu - manage');

$this->menu = array(
	array(
		'label' => Yii::t('MenuModule.menu', 'Menu'),
		'items' => array(
			array('icon' => 'list-alt', 'label' => Yii::t('MenuModule.menu', 'Manage menu'), 'url' => array('/menu/menuBackend/index')),
			array('icon' => 'plus-sign', 'label' => Yii::t('MenuModule.menu', 'Create menu'), 'url' => array('/menu/menuBackend/create')),
		)
	),
	array(
		'label' => Yii::t('MenuModule.menu', 'Menu items'),
		'items' => array(
			array('icon' => 'list-alt', 'label' => Yii::t('MenuModule.menu', 'Manage menu items'), 'url' => array('/menu/menuitemBackend/index')),
			array('icon' => 'plus-sign', 'label' => Yii::t('MenuModule.menu', 'Create menu item'), 'url' => array('/menu/menuitemBackend/create')),
		)
	),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('MenuModule.menu', 'Menu'); ?>
        <small><?php echo Yii::t('MenuModule.menu', 'manage'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('MenuModule.menu', 'Find menu'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript(
    'search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('menu-grid', {
            data: $(this).serialize()
        });
        return false;
    });"
);
$this->renderPartial('_search', array('model' => $model));
?>
</div>

</br>

<p><?php echo Yii::t('MenuModule.menu', 'This section describes Menu Management'); ?></p>

<?php $this->widget(
    'yupe\widgets\CustomGridView', array(
        'id'           => 'menu-grid',
        'type'         => 'condensed',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'bulkActions'      => array(
            'actionButtons' => array(
                array(
                    'id'         => 'delete-post',
                    'buttonType' => 'button',
                    'type'       => 'danger',
                    'size'       => 'small',
                    'label'      => Yii::t('MenuModule.menu', 'Delete'),
                    'click'      => 'js:function(values){ if(!confirm("' . Yii::t('MenuModule.menu', 'Do you really want to delete selected elements?') . '")) return false; multiaction("delete", values); }',
                ),
            ),
            'checkBoxColumnConfig' => array(
                'name' => 'id'
            ),
        ),
        'columns'      => array(
            array(
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'name'  => 'name',
                'editable' => array(
                    'url' => $this->createUrl('/menu/menuBackend/inline'),
                    'mode' => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                )
            ),
            array(
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'name'  => 'code',
                'editable' => array(
                    'url' => $this->createUrl('/menu/menuBackend/inline'),
                    'mode' => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                )
            ),
            array(
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'name'  => 'description',
                'editable' => array(
                    'url' => $this->createUrl('/menu/menuBackend/inline'),
                    'mode' => 'inline',
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                )
            ),
            array(
                'class'  => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url'  => $this->createUrl('/menu/menuBackend/inline'),
                    'mode' => 'popup',
                    'type' => 'select',
                    'source' => $model->getStatusList(),
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'name'   => 'status',
                'type'   => 'raw',
                'value'  => '$data->getStatus()',
                'filter' => $model->getStatusList()
            ),
            array(
                'header' => Yii::t('MenuModule.menu', 'Items'),
                'type'   => 'raw',
                'value'  => 'CHtml::link(count($data->menuItems), Yii::app()->createUrl("/menu/menuitemBackend/index", array("MenuItem[menu_id]" => $data->id)))',
            ),
            array(
                'class'       => 'bootstrap.widgets.TbButtonColumn',
                'template'    => '{view}{update}{delete}{add}',
                'buttons'  => array(
                    'add' => array(
                        'label'   => false,
                        'url'     => 'Yii::app()->createUrl("/menu/menuitemBackend/create", array("mid" => $data->id))',
                        'options' => array(
                            'class' => 'icon-plus-sign',
                            'title' => Yii::t('MenuModule.menu', 'Create menu item'),
                        ),
                    ),
                ),
            ),
        ),
    )
); ?>