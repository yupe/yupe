<?php
$this->breadcrumbs = array(
    Yii::t('RbacModule.rbac', 'Actions') => array('index'),
    Yii::t('RbacModule.rbac', 'Manage'),
);

$this->menu = array(
    array(
        'label' => Yii::t('RbacModule.rbac', 'Roles'),
        'items' => array(
            array(
                'icon' => 'list-alt',
                'label' => Yii::t('RbacModule.rbac', 'Manage roles'),
                'url' => array('/rbac/rbacBackend/index')
            ),
            array(
                'icon' => 'plus-sign',
                'label' => Yii::t('RbacModule.rbac', 'Create role'),
                'url' => array('/rbac/rbacBackend/create')
            ),
        )
    ),
    array(
        'label' => Yii::t('RbacModule.rbac', 'Users'),
        'items' => array(
            array(
                'icon' => 'list-alt',
                'label' => Yii::t('RbacModule.rbac', 'Users'),
                'url' => array('/rbac/rbacBackend/userList')
            ),
        )
    ),
);

?>

<h3><?php echo Yii::t('RbacModule.rbac', 'Manage items'); ?></h3>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    array(
        'id' => 'auth-item-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        'columns' => array(
            array(
                'name' => 'name',
                'value' => 'CHtml::link($data->name, array("/rbac/rbacBackend/update", "id" => $data->name))',
                'type' => 'html'
            ),
            array(
                'name' => 'description',
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'headerHtmlOptions' => array('style' => 'width:500px'),
                'editable' => array(
                    'type' => 'text',
                    'url' => array('/rbac/rbacBackend/inlineEdit'),
                    'title' => Yii::t(
                            'RbacModule.rbac',
                            'Enter {field}',
                            array('{field}' => mb_strtolower($model->getAttributeLabel('description')))
                        ),
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
            ),
            array(
                'name' => 'type',
                'filter' => AuthItem::model()->getTypeList(),
                'value' => '$data->getType()',
                'class' => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url' => $this->createUrl('/rbac/rbacBackend/inlineEdit'),
                    'mode' => 'popup',
                    'type' => 'select',
                    'title' => Yii::t(
                            'RbacModule.rbac',
                            'Select {field}',
                            array('{field}' => mb_strtolower($model->getAttributeLabel('type')))
                        ),
                    'source' => AuthItem::model()->getTypeList(),
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'type' => 'raw',
            ),
            array(
                'class' => 'bootstrap.widgets.TbButtonColumn',
            ),
        ),
    )
); ?>
