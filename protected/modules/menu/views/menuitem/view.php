<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('menu')->getCategory() => array(),
        Yii::t('MenuModule.menu', 'Menu') => array('/menu/menu/index'),
        Yii::t('MenuModule.menu', 'Menu items') => array('/menu/menuitem/index'),
        $model->title,
    );

    $this->pageTitle = Yii::t('MenuModule.menu', 'Menu items - show');

    $this->menu = array(
        array('label' => Yii::t('MenuModule.menu', 'Menu'), 'items' => array(
            array('icon' => 'plus-sign', 'label' => Yii::t('MenuModule.menu', 'Create menu'), 'url' => array('/menu/menu/create')),
            array('icon' => 'list-alt', 'label' => Yii::t('MenuModule.menu', 'Manage menu'), 'url' => array('/menu/menu/index')),
        )),
        array('label' => Yii::t('MenuModule.menu', 'Menu items'), 'items' => array(
            array('icon' => 'plus-sign', 'label' => Yii::t('MenuModule.menu', 'Create menu item'), 'url' => array('/menu/menuitem/create')),
            array('icon' => 'list-alt', 'label' => Yii::t('MenuModule.menu', 'Manage menu items'), 'url' => array('/menu/menuitem/index')),
            array('label' => Yii::t('MenuModule.menu', 'Menu item') . ' «' . $model->title . '»'),
            array('icon' => 'pencil', 'label' => Yii::t('MenuModule.menu', 'Change menu item'), 'url' => array('/menu/menuitem/update', 'id' => $model->id)),
            array('icon' => 'eye-open', 'encodeLabel' => false, 'label' => Yii::t('MenuModule.menu', 'View menu item'), 'url' => array(
                '/menu/menuitem/view',
                'id' => $model->id
            )),
            array('icon' => 'trash', 'label' => Yii::t('MenuModule.menu', 'Remove menu item'), 'url' => '#', 'linkOptions' => array(
                'submit' => array('/menu/menuitem/delete', 'id' => $model->id),
                'confirm' => Yii::t('MenuModule.menu', 'Do you really want to delete?')),
            ),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('MenuModule.menu', 'Show menu item'); ?><br />
        <small>&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
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
)); ?>