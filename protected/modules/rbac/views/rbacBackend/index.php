<?php
$this->breadcrumbs = [
    Yii::t('RbacModule.rbac', 'RBAC') => ['index'],
    Yii::t('RbacModule.rbac', 'Manage'),
];

$this->menu = $this->module->getNavigation();
?>

<h3><?php echo Yii::t('RbacModule.rbac', 'Manage operations'); ?></h3>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    [
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
        'columns'      => [
            [
                'class'=>'CCheckBoxColumn',
            ],
            [
                'name'  => 'name',
                'value' => 'CHtml::link($data->name, array("/rbac/rbacBackend/update", "id" => $data->name))',
                'type'  => 'html'
            ],
            [
                'name'              => 'description',
                'class'             => 'bootstrap.widgets.TbEditableColumn',
                'headerHtmlOptions' => ['style' => 'width:500px'],
                'editable'          => [
                    'type'   => 'text',
                    'url'    => ['/rbac/rbacBackend/inlineEdit'],
                    'title'  => Yii::t(
                            'RbacModule.rbac',
                            'Enter {field}',
                            ['{field}' => mb_strtolower($model->getAttributeLabel('description'))]
                        ),
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'filter'            => CHtml::activeTextField($model, 'description', ['class' => 'form-control']),
            ],
            [
                'name'     => 'type',
                'filter'   => CHtml::activeDropDownList(
                        $model,
                        'type',
                        AuthItem::model()->getTypeList(),
                        ['class' => 'form-control', 'empty' => '']
                    ),
                'value'    => '$data->getType()',
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => [
                    'url'    => $this->createUrl('/rbac/rbacBackend/inlineEdit'),
                    'mode'   => 'popup',
                    'type'   => 'select',
                    'title'  => Yii::t(
                            'RbacModule.rbac',
                            'Select {field}',
                            ['{field}' => mb_strtolower($model->getAttributeLabel('type'))]
                        ),
                    'source' => AuthItem::model()->getTypeList(),
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'type'     => 'raw',
            ],
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
            ],
        ],
    ]
); ?>
