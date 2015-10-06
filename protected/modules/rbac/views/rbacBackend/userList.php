<?php
$this->breadcrumbs = [
    Yii::t('RbacModule.rbac', 'RBAC') => ['index'],
    Yii::t('RbacModule.rbac', 'User list'),
];

$this->menu = $this->module->getNavigation();
?>
<div class="page-header">
    <h3>
        <?php echo Yii::t('RbacModule.rbac', 'Users'); ?>
        <small><?php echo Yii::t('RbacModule.rbac', 'management'); ?></small>
    </h3>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo Yii::t('RbacModule.rbac', 'Find users'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out search-form">
    <?php
    Yii::app()->clientScript->registerScript(
        'search',
        "
               $('.search-form form').submit(function () {
                   event.preventDefault();

                   $.fn.yiiGridView.update('user-grid', {
                       data: $(this).serialize()
                   });
               });

               $(document).on('click', '.verify-email', function () {
                   var link = $(this);

                   event.preventDefault();

                   $.post(link.attr('href'), actionToken.token)
                       .done(function (response) {
                           bootbox.alert(response.data);
                       });
               });
           "
    );
    $this->renderPartial('_searchUser', ['model' => $model]); ?>
</div>

<?php
Yii::import('bootstrap.widgets.TbExtendedGridView');
$this->widget(
    'TbExtendedGridView',
    [
        'id'           => 'user-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => [
            [
                'name'  => 'nick_name',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->getFullName(), array("/user/userBackend/view", "id" => $data->id))',
            ],
            [
                'name'  => 'email',
                'value' => '$data->email',
            ],
            [
                'filter' => false,
                'value'  => function ($data) {
                        echo CHtml::link(
                            Yii::t('RbacModule.rbac', 'Roles'),
                            ['/rbac/rbacBackend/assign', 'id' => $data->id],
                            ['class' => 'btn btn-default btn-small']
                        );
                    }
            ],
        ],
    ]
);
?>
