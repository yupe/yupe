<script type="text/javascript">
    $(document).ready(function(){
        $("#menu-items-grid").find('tr').attr("style","cursor:move;");
    });
</script>

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
        <?php echo Yii::t('MenuModule.menu', 'Menu items'); ?>
        <small><?php echo Yii::t('MenuModule.menu', 'manage'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('MenuModule.menu', 'Find menu items'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('menu-items-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->renderPartial('_search', array('model' => $model));
?>
</div>

</br>

<p><?php echo Yii::t('MenuModule.menu', 'This section describes Menu Items Management'); ?> <span class="label label-info"><?php echo Yii::t('MenuModule.menu','Use drag and drop to sort');?></span></p>

<?php $this->widget('yupe\widgets\CustomGridView', array(
    'id'           => 'menu-items-grid',
    'sortableRows' => true,
    'sortableAjaxSave'=>true,
    'sortableAttribute'=>'sort',
    'sortableAction'=>'/menu/menuitemBackend/sortable',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        array(
            'class' => 'bootstrap.widgets.TbEditableColumn',
            'name'  => 'title',
            'editable' => array(
                'url' => $this->createUrl('/menu/menuitemBackend/inline'),
                'mode' => 'inline',
                'params' => array(
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                )
            )
        ),
        array(
            'class' => 'bootstrap.widgets.TbEditableColumn',
            'name'  => 'href',
            'editable' => array(
                'url' => $this->createUrl('/menu/menuitemBackend/inline'),
                'mode' => 'inline',
                'params' => array(
                    Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                )
            )
        ),
        array(
            'name'   => 'menu_id',
            'value'  => '$data->menu->name',
            'filter' =>  CHtml::listData(Menu::model()->findAll(), 'id', 'name')
        ),
        array(
            'name'   => 'parent_id',
            'value'  => '$data->getParent()',
            'filter' => CHtml::activeDropDownList($model, 'parent_id', $model->parentTree, array('disabled' => ($model->menu_id) ? false : true) + array('encode' => false)),
        ),
        array(
            'name'   => 'condition_name',
            'value'  => '$data->getConditionName()',
            'filter' => $model->getConditionList(),
        ),
        array(
            'class'  => 'bootstrap.widgets.TbEditableColumn',
			'editable' => array(
				'url'    => $this->createUrl('/menu/menuitemBackend/inline'),
				'mode'   => 'popup',
				'type'   => 'select',
				'title'  => Yii::t('MenuModule.menu', 'Select {field}', array('{field}' => mb_strtolower($model->getAttributeLabel('status')))),
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
            'name'   => 'sort',
            'type'   => 'raw',
            'value'  => '$this->grid->getUpDownButtons($data)',
            'filter' => false
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>