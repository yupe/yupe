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

<h1><?php echo $this->module->getName(); ?></h1>

<?php echo CHtml::link(Yii::t('user', 'Поиск пользователей'), '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array('model' => $model)); ?>
</div><!-- search-form -->

<?php
$this->widget('YCustomGridView', array(
    'id' => 'user-grid',
    'dataProvider' => $model->search(),
    'columns' => array(
        'id',
        array(
            'name' => 'nick_name',
            'type' => 'raw',
            'value' => 'CHtml::link($data->nick_name, array("/user/default/update/", "id" => $data->id))',
        ),
        'email',
        array(
            'name' => 'access_level',
            'value' => '$data->getAccessLevel()',
            'filter' => CHtml::activeDropDownList($model, 'status', $model->getAccessLevelsList()),
        ),
        'creation_date',
        'last_visit',
        array(
            'name' => 'status',
            'type' => 'raw',
            'value' => '$this->grid->returnStatusHtml($data, Comment::STATUS_APPROVED, 1)',
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{view} {update} {password} {delete}',
            'buttons' => array(
                'password' => array(
                    'label' => Yii::t('user', 'Изменить пароль'),
                    'imageUrl' => Yii::app()->request->baseUrl . '/web/images/key.gif',
                    'url' => 'array("/user/default/changepassword/", "id"=>$data->id)',
                ),
            ),
        ),
    ),
));
?>
