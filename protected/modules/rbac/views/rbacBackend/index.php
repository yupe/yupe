<?php
$this->breadcrumbs = array(
    'Действия' => array('index'),
    'Управление',
);

$this->menu = array(
    array('label' => Yii::t('RbacModule.rbac', 'Roles'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('RbacModule.rbac', 'Manage roles'), 'url' => array('/rbac/rbacBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('RbacModule.rbac', 'Create role'), 'url' => array('/rbac/rbacBackend/create')),
    )),
    array('label' => Yii::t('RbacModule.rbac', 'Assign'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('RbacModule.rbac', 'Assign roles'), 'url' => array('/user/tokensBackend/index')),
    )),
);

?>

<h1>Управление действиями</h1>

<?php $this->widget(
    'bootstrap.widgets.TbExtendedGridView',
    array(
        'id' => 'auth-item-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'columns' => array(
            array(
                'name'  => 'name',
                'value' => 'CHtml::link($data->name, array("/rbac/authItem/update", "id" => $data->name))',
                'type'  => 'html'
            ),
            array(
                'name' => 'description',
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'headerHtmlOptions' => array('style' => 'width:500px'),
                'editable' => array(
                    'type' => 'text',
                    'url' => array('/rbac/authItem/inlineEdit')
                ),
            ),
            array(
                'name' => 'type',
                'filter' =>AuthItem::model()->getTypeList(),
                'value' => '$data->getType()'
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    )
); ?>
