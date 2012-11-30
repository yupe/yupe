<?php
$this->pageTitle = Yii::t('user', 'Управление пользователями');

$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('/user/default/index'),
    Yii::t('user', 'Управление'),
);

$this->menu = array(
    array('label' => Yii::t('user', 'Пользователи')),
    array('icon' => 'list', 'label' => Yii::t('user', 'Управление пользователями'), 'url' => array('/user/default/index')),
    array('icon' => 'plus-sign', 'label' => Yii::t('user', 'Добавление пользователя'), 'url' => array('/user/default/create')),
    array('label' => Yii::t('user', 'Восстановления паролей')),
    array('icon' => 'list', 'label' => Yii::t('user', 'Восстановления паролей'), 'url' => array('/user/recoveryPassword/index')),
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

<div class="page-header">
    <h1>
        <?php echo Yii::t('user', 'Пользователи'); ?>
        <small><?php echo Yii::t('user', 'управление'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('user', 'Поиск пользователей'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('user-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->renderPartial('_search', array('model' => $model));
?>
</div>

<br/>

<p><?php echo Yii::t('user', 'В данном разделе представлены средства управления пользователями'); ?></p>

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
            'value' => 'CHtml::link($data->nick_name, array("/user/default/update", "id" => $data->id))',
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
            'class'    => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{view}{update}{password}{delete}',
            'buttons'  => array(
                'password' => array(
                    'icon'     => 'lock',
                    'label'    => Yii::t('user', 'Изменить пароль'),
                    'url'      => 'array("/user/default/changepassword", "id" => $data->id)',
                ),
            ),
        ),
    ),
));
?>