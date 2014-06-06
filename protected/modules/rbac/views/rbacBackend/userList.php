<?php
$this->breadcrumbs = array(
    'Действия' => array('index'),
    'список пользователей',
);

$this->menu = array(
    array('label' => Yii::t('RbacModule.rbac', 'Roles'), 'items' => array(
        array('icon' => 'list-alt', 'label' => Yii::t('RbacModule.rbac', 'Manage roles'), 'url' => array('index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('RbacModule.rbac', 'Create role'), 'url' => array('create')),
        array('icon' => 'user', 'label' => Yii::t('RbacModule.rbac', 'User list'), 'url' => array('userList')),
    )),
);

?>
    <div class="page-header">
        <h1>
            <?php echo Yii::t('UserModule.user', 'Users'); ?>
            <small><?php echo Yii::t('UserModule.user', 'management'); ?></small>
        </h1>
    </div>

    <button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="icon-search">&nbsp;</i>
        <?php echo CHtml::link(Yii::t('UserModule.user', 'Find users'), '#', array('class' => 'search-button')); ?>
        <span class="caret">&nbsp;</span>
    </button>

    <div id="search-toggle" class="collapse out search-form">
        <?php
        Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function() {
        event.preventDefault();

        $.fn.yiiGridView.update('user-grid', {
            data: $(this).serialize()
        });
    });

    $(document).on('click', '.verify-email', function(){
        var link = $(this);

        event.preventDefault();

        $.post(link.attr('href'), actionToken.token)
            .done(function(response){
                bootbox.alert(response.data);
            });
    });
");
        $this->renderPartial('_searchUser', array('model' => $model));
        ?>
    </div>

    <br/>

    <p><?php echo Yii::t('UserModule.user', 'This section represents account management!'); ?></p>

<?php
Yii::import('bootstrap.widgets.TbExtendedGridView');
$this->widget('TbExtendedGridView', array(
    'id'           => 'user-grid',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        array(
            'name'        => 'id',
            'value' => 'CHtml::link($data->id, array("/user/userBackend/view", "id" => $data->id))',
            'type'  => 'html',
            'htmlOptions' => array(
                'style'   => 'width: 40px; text-align: center'
            )
        ),
        array(
            'name'  => 'nick_name',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->nick_name, array("/user/userBackend/view", "id" => $data->id))',
        ),
        array(
            'name'  => 'email',
            'value' => '$data->email',
        ),
        array(
            'header'   => 'Права доступа',
            'filter' => false,
            'value'=> function($data){
                echo CHtml::link('Права',array('/rbac/rbacBackend/assign','id'=>$data->id),array('class'=>'btn btn-small'));
            }
        ),

    ),
));
?>