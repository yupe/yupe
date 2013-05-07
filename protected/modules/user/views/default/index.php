<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('user')->getCategory() => array(),
        Yii::t('UserModule.user', 'Пользователи') => array('/user/default/index'),
        Yii::t('UserModule.user', 'Управление'),
    );

    $this->pageTitle = Yii::t('UserModule.user', 'Пользователи - управление');

    $this->menu = array(
        array('label' => Yii::t('UserModule.user', 'Пользователи'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('UserModule.user', 'Управление пользователями'), 'url' => array('/user/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('UserModule.user', 'Добавление пользователя'), 'url' => array('/user/default/create')),
        )),
        array('label' => Yii::t('UserModule.user', 'Восстановления паролей'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('UserModule.user', 'Восстановления паролей'), 'url' => array('/user/recoveryPassword/index')),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('UserModule.user', 'Пользователи'); ?>
        <small><?php echo Yii::t('UserModule.user', 'управление'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('UserModule.user', 'Поиск пользователей'), '#', array('class' => 'search-button')); ?>
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

<p><?php echo Yii::t('UserModule.user', 'В данном разделе представлены средства управления пользователями'); ?></p>

<?php $this->widget('YCustomGridView', array(
    'id'            => 'user-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        array(
            'name'        => 'id',
            'value'       => '$data->id',
            'htmlOptions' => array(
                'style'   => 'width: 40px; text-align: center'
            )
        ),
         array(
            'name'  => 'nick_name',
            'type'  => 'raw',
            'value' => 'CHtml::link($data->nick_name, array("/user/default/update", "id" => $data->id))',
        ),
        'email',
        array(
            'name'   => 'access_level',
            'value'  => '$data->getAccessLevel()',
            'filter' => CHtml::activeDropDownList($model, 'access_level', $model->accessLevelsList),
        ),
        array(
            'name'  => 'creation_date',
            'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->creation_date, "short", "short")',
        ),
        'last_visit',
        array(
            'name'  => 'status',
            'type'  => 'raw',
            'value' => '$this->grid->returnBootstrapStatusHtml($data, "status", "Status")',
        ),
        array(
            'class'    => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{view}{update}{password}{sendactivation}{delete}',
            'buttons'  => array(
                'password' => array(
                    'icon'     => 'lock',
                    'label'    => Yii::t('UserModule.user', 'Изменить пароль'),
                    'url'      => 'array("/user/default/changepassword", "id" => $data->id)',
                ),
                'sendactivation' => array(
                    'label'   => Yii::t('UserModule.user', 'Отправить подтверждение активации'),
                    'url'     => 'array("/user/default/sendactivation", "id" => $data->id)',
                    'icon'    => 'repeat',
                    'visible' => '$data->needActivation()',
                    'options'  => array(
                        'class' => 'user sendactivation'
                    )
                ),
            ),
            'htmlOptions' => array(
                'style'   => 'width: 80px; text-align: right;'
            )
        ),
    ),
)); ?>