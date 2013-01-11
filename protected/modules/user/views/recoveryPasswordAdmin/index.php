<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('user')->getCategory() => array(),
        Yii::t('UserModule.user', 'Пользователи') => array('/user/default/index'),
        Yii::t('UserModule.user', 'Восстановление пароля') => array('/user/recoveryPassword/index'),
        Yii::t('UserModule.user', 'Управление'),
    );

    $this->pageTitle = Yii::t('UserModule.user', 'Восстановление пароля - управление');

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
        <?php echo Yii::t('UserModule.user', 'Восстановления паролей'); ?>
        <small><?php echo Yii::t('UserModule.user', 'управление'); ?></small>
    </h1>
</div>

<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('UserModule.user', 'Поиск паролей'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
<?php
Yii::app()->clientScript->registerScript('search', "
    $('.search-form form').submit(function() {
        $.fn.yiiGridView.update('recovery-password-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");
$this->renderPartial('_search', array('model' => $model));
?>
</div>

<br/>

<p><?php echo Yii::t('UserModule.user', 'В данном разделе представлены средства управления восстановлениями паролей'); ?></p>

<?php $this->widget('YCustomGridView', array(
    'id' => 'recovery-password-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
    'filter'       => $model,
    'columns'      => array(
        'id',
        array(
            'name' => 'user_id',
            'value' => '$data->user->getFullName()." ({$data->user->nick_name})"'
        ),
        'creation_date',
        'code',
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{delete}',
        ),
    ),
)); ?>