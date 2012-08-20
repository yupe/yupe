<?php

    $this->pageTitle = Yii::t('user', 'Управление пользователями');

    $this->breadcrumbs = array(
        Yii::t('user', 'Пользователи') => array('admin'),
        Yii::t('user', 'Управление'),
    );

    $this->menu = array(
        array('icon' => 'th-large white', 'label' => Yii::t('user', 'Управление пользователями'), 'url' => array('/user/default/admin')),
        array('icon' => 'th-list', 'label' => Yii::t('user', 'Список пользователей'), 'url' => array('/user/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('user', 'Добавление пользователя'), 'url' => array('/user/default/create')),
        array('label' => Yii::t('user', 'Восстановления паролей')),
        array('icon' => 'th-large', 'label' => Yii::t('user', 'Управление восстановлением паролей'), 'url' => array('/user/recoveryPassword/admin')),
        array('icon' => 'th-list', 'label' => Yii::t('user', 'Список восстановлений'), 'url' => array('/user/recoveryPassword/index')),
    );

    Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function() {
            $('.search-form').toggle();
            return false;
        });
        $('.search-form form').submit(function() {
            $.fn.yiiGridView.update('user-grid', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
?>

<div class="page-header"><h1><?php echo $this->module->getName(); ?> <small><?php echo Yii::t('yupe', 'управление'); ?></small></h1></div>
<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle" >
    <i class="icon-search"></i>
    <a class="search-button" href="#"><?php echo Yii::t('user', 'Поиск пользователей'); ?></a> <span class="caret"></span>
</button>

<div id="search-toggle" class="collapse out">
    <?php Yii::app()->clientScript->registerScript('search', "
        $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('good-grid', {
                data: $(this).serialize()
            });
            return false;
        });
    ");
    $this->renderPartial('_search', array('model' => $model));
    ?>
</div>

<?php
$this->widget('YCustomGridView', array(
    'id'            => 'user-grid',
    'dataProvider'  => $model->search(),
    'itemsCssClass' => ' table table-condensed',
    'columns'       => array(
        'id',
        array(
            'name'  => 'nick_name',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->nick_name, array("/user/default/update/", "id" => $data->id))',
        ),
        'email',
        array(
            'name'   => 'access_level',
            'value'  => '$data->getAccessLevel()',
            'filter' => CHtml::activeDropDownList($model, 'status', $model->getAccessLevelsList()),
        ),
        'creation_date',
        'last_visit',
        array(
            'name'  => 'status',
            'type'  => 'raw',
            'value' => '$this->grid->returnBootstrapStatusHtml($data)',
        ),
        array(
            'type'  => 'raw',
            'value' => '$data->email_confirm ? null : CHtml::link(\'<i class="icon icon-envelope" title="Выслать просьбу о подтверждении аккаунта"></i>\',
                Yii::app()->controller->createUrl("notify", array("model" => "User", "id" => $data->id)),
                array("onclick" => "ajaxSetStatus(this, \"user-grid\"); return false;"))',
        ),
        array(
            'class'    => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{view}{update}{password}{delete}',
            'buttons'  => array(
                'password' => array(
                    'icon'     => 'lock',
                    'label'    => Yii::t('user', 'Изменить пароль'),
                    'imageUrl' => Yii::app()->request->baseUrl . '/web/images/key.gif',
                    'url'      => 'array("/user/default/changepassword/", "id" => $data->id)',
                ),
            ),
        ),
    ),
));
?>
