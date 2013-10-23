<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('user')->getCategory() => array(),
        Yii::t('UserModule.user', 'Users') => array('/user/userBackend/index'),
        Yii::t('UserModule.user', 'Management'),
    );

    $this->pageTitle = Yii::t('UserModule.user', 'Users - management');

    $this->menu = array(
        array('label' => Yii::t('UserModule.user', 'Users'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('UserModule.user', 'Manage users'), 'url' => array('/user/userBackend/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('UserModule.user', 'Create user'), 'url' => array('/user/userBackend/create')),
        )),
        array('label' => Yii::t('UserModule.user', 'Tokens'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('UserModule.user', 'Token list'), 'url' => array('/user/tokensBackend/index')),
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

<p><?php echo Yii::t('UserModule.user', 'This section represents account management!'); ?></p>

<?php $this->widget('yupe\widgets\CustomGridView', array(
    'id'            => 'user-grid',
    'type'         => 'condensed',
    'dataProvider' => $model->search(),
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
            'value' => 'CHtml::link($data->nick_name, array("/user/userBackend/update", "id" => $data->id))',
        ),
        'email',
        array(
            'name'   => 'access_level',
            'value'  => '$data->getAccessLevel()',
        ),
        array(
            'name'  => 'creation_date',
            'value' => 'Yii::app()->getDateFormatter()->formatDateTime($data->creation_date, "short", "short")',
        ),
        'last_visit',
        array(
            'name'   => 'status',
            'type'   => 'raw',
            'value'  => '$data->changeStatus($this->grid)',
        ),
        array(
            'header'   => Yii::t('UserModule.user', 'Management'),
            'class'    => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{view}{update}{password}{sendactivation}{delete}',
            'buttons'  => array(
                'password' => array(
                    'icon'     => 'lock',
                    'label'    => Yii::t('UserModule.user', 'Change password'),
                    'url'      => 'array("/user/userBackend/changepassword", "id" => $data->id)',
                ),
                'sendactivation' => array(
                    'label'   => Yii::t('UserModule.user', 'Send activation confirm'),
                    'url'     => 'array("/user/userBackend/sendactivation", "id" => $data->id)',
                    'icon'    => 'repeat',
                    'visible' => '$data->getIsActivated() === false',
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