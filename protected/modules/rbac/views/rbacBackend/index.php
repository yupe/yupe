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
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('RbacModule.rbac', 'Manage roles'),
                'url'   => array('/rbac/rbacBackend/index')
            ),
            array(
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('RbacModule.rbac', 'Create role'),
                'url'   => array('/rbac/rbacBackend/create')
            ),
        )
    ),
    array(
        'label' => Yii::t('RbacModule.rbac', 'Users'),
        'items' => array(
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('RbacModule.rbac', 'Users'),
                'url'   => array('/rbac/rbacBackend/userList')
            ),
        )
    ),
);

?>

<h3><?php echo Yii::t('RbacModule.rbac', 'Manage items'); ?></h3>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    array(
        'id'           => 'auth-item-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'actionsButtons' => [
            CHtml::link(
                Yii::t('YupeModule.yupe', 'Add'),
                ['/rbac/rbacBackend/create'],
                ['class' => 'btn btn-success pull-right btn-sm']
            )
        ],
        'columns'      => array(
            array(
                'name'  => 'name',
                'value' => 'CHtml::link($data->name, array("/rbac/rbacBackend/update", "id" => $data->name))',
                'type'  => 'html'
            ),
            array(
                'name'              => 'description',
                'class'             => 'bootstrap.widgets.TbEditableColumn',
                'headerHtmlOptions' => array('style' => 'width:500px'),
                'editable'          => array(
                    'type'   => 'text',
                    'url'    => array('/rbac/rbacBackend/inlineEdit'),
                    'title'  => Yii::t(
                            'RbacModule.rbac',
                            'Enter {field}',
                            array('{field}' => mb_strtolower($model->getAttributeLabel('description')))
                        ),
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'filter'            => CHtml::activeTextField($model, 'description', array('class' => 'form-control')),
            ),
            array(
                'name'     => 'type',
                'filter'   => CHtml::activeDropDownList(
                        $model,
                        'type',
                        AuthItem::model()->getTypeList(),
                        array('class' => 'form-control', 'empty' => '')
                    ),
                'value'    => '$data->getType()',
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url'    => $this->createUrl('/rbac/rbacBackend/inlineEdit'),
                    'mode'   => 'popup',
                    'type'   => 'select',
                    'title'  => Yii::t(
                            'RbacModule.rbac',
                            'Select {field}',
                            array('{field}' => mb_strtolower($model->getAttributeLabel('type')))
                        ),
                    'source' => AuthItem::model()->getTypeList(),
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'type'     => 'raw',
            ),
            array(
                'class' => 'yupe\widgets\CustomButtonColumn',
            ),
        ),
    )
); ?>
