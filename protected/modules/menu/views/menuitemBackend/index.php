<?php
    $this->breadcrumbs = array(       
        Yii::t('MenuModule.menu', 'Menu') => array('/menu/menuBackend/index'),
        Yii::t('MenuModule.menu', 'Menu items'),
    );

    $this->pageTitle = Yii::t('MenuModule.menu', 'Menu items - remove');

    $this->menu = array(
        array('label' => Yii::t('MenuModule.menu', 'Menu'), 'items' => array(
            array('icon' => 'plus-sign', 'label' => Yii::t('MenuModule.menu', 'Create menu'), 'url' => array('/menu/menuBackend/create')),
            array('icon' => 'list-alt', 'label' => Yii::t('MenuModule.menu', 'Manage menu'), 'url' => array('/menu/menuBackend/index')),
        )),
        array('label' => Yii::t('MenuModule.menu', 'Menu items'), 'items' => array(
            array('icon' => 'plus-sign', 'label' => Yii::t('MenuModule.menu', 'Create menu item'), 'url' => array('/menu/menuitemBackend/create')),
            array('icon' => 'list-alt', 'label' => Yii::t('MenuModule.menu', 'Manage menu items'), 'url' => array('/menu/menuitemBackend/index')),
        )),
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

<p><?php echo Yii::t('MenuModule.menu', 'This section describes Menu Items Management'); ?></p>

<?php $this->widget('yupe\widgets\CustomGridView', array(
    'id'           => 'menu-items-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        array(
            'name'        => 'id',
            'htmlOptions' => array('style' => 'width:50px'),
        ),
        'title',
        'href',
        array(
            'name'        => 'menu_id',
            'type'        => 'raw',
            'value'       => 'CHtml::link($data->menu->name, Yii::app()->createUrl("/menu/menuBackend/update", array("id" => $data->menu->id)))',
            'filter'      => CHtml::activeDropDownList($model, 'menu_id', $model->menuList, array('empty' => '')),
            'htmlOptions' => array('style' => 'width:110px'),
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
            'name'  => 'sort',
            'type'  => 'raw',
            'value' => '$this->grid->getUpDownButtons($data)',
        ),
        array(
            'name'        => 'status',
            'type'        => 'raw',
            'value'       => '$this->grid->returnBootstrapStatusHtml($data, "status", "Status", array("lock", "ok-sign"))',
            'filter'      => $model->statusList,
            'htmlOptions' => array('style' => 'width:110px'),
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
)); ?>