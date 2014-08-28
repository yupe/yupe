<?php

/**
 * @var $model User
 * @var $this UserBackendController
 */

$this->breadcrumbs = array(
    Yii::t('UserModule.user', 'Users') => array('/user/userBackend/index'),
    Yii::t('UserModule.user', 'Management'),
);

$this->pageTitle = Yii::t('UserModule.user', 'Users - management');

$this->menu = array(
    array(
        'label' => Yii::t('UserModule.user', 'Users'),
        'items' => array(
            array(
                'icon'  => 'glyphicon glyphicon-list-alt',
                'label' => Yii::t('UserModule.user', 'Manage users'),
                'url'   => array('/user/userBackend/index')
            ),
            array(
                'icon'  => 'glyphicon glyphicon-plus-sign',
                'label' => Yii::t('UserModule.user', 'Create user'),
                'url'   => array('/user/userBackend/create')
            ),
        )
    ),
    array(
        'label' => Yii::t('UserModule.user', 'Tokens'),
        'items' => array(
            array(
                'icon'  => 'glyphicon glyphicon-list-alt',
                'label' => Yii::t('UserModule.user', 'Token list'),
                'url'   => array('/user/tokensBackend/index')
            ),
        )
    ),
);
?>

<div class="page-header">
    <h1>
        <?php echo Yii::t('UserModule.user', 'Users'); ?>
        <small><?php echo Yii::t('UserModule.user', 'management'); ?></small>
    </h1>
</div>

<p>
    <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
        <i class="glyphicon glyphicon-search">&nbsp;</i>
        <?php echo Yii::t('UserModule.user', 'Find users'); ?>
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
    $this->renderPartial('_search', array('model' => $model));
    ?>
</div>

<p><?php echo Yii::t('UserModule.user', 'This section represents account management!'); ?></p>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    array(
        'id'           => 'user-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => array(
            array(
                'name'  => 'nick_name',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->nick_name, array("/user/userBackend/update", "id" => $data->id))',
            ),
            array(
                'name'  => 'email',
                'type'  => 'raw',
                'value' => 'CHtml::link($data->email, "mailto:" . $data->email)',
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url'    => $this->createUrl('/user/userBackend/inline'),
                    'mode'   => 'popup',
                    'type'   => 'select',
                    'title'  => Yii::t(
                            'UserModule.user',
                            'Select {field}',
                            array('{field}' => mb_strtolower($model->getAttributeLabel('access_level')))
                        ),
                    'source' => $model->getAccessLevelsList(),
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'name'     => 'access_level',
                'type'     => 'raw',
                'value'    => '$data->getAccessLevel()',
                'filter'   => CHtml::activeDropDownList(
                        $model,
                        'access_level',
                        $model->getAccessLevelsList(),
                        array('class' => 'form-control', 'empty' => '')
                    ),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url'    => $this->createUrl('/user/userBackend/inline'),
                    'mode'   => 'popup',
                    'type'   => 'select',
                    'title'  => Yii::t(
                            'UserModule.user',
                            'Select {field}',
                            array('{field}' => mb_strtolower($model->getAttributeLabel('status')))
                        ),
                    'source' => $model->getStatusList(),
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'name'     => 'status',
                'type'     => 'raw',
                'value'    => '$data->getStatus()',
                'filter'   => CHtml::activeDropDownList(
                        $model,
                        'status',
                        $model->getStatusList(),
                        array('class' => 'form-control', 'empty' => '')
                    ),
            ),
            array(
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'editable' => array(
                    'url'    => $this->createUrl('/user/userBackend/inline'),
                    'mode'   => 'popup',
                    'type'   => 'select',
                    'title'  => Yii::t(
                            'UserModule.user',
                            'Select {field}',
                            array('{field}' => mb_strtolower($model->getAttributeLabel('email_confirm')))
                        ),
                    'source' => $model->getEmailConfirmStatusList(),
                    'params' => array(
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    )
                ),
                'name'     => 'email_confirm',
                'type'     => 'raw',
                'value'    => '$data->getEmailConfirmStatus()',
                'filter'   => CHtml::activeDropDownList(
                        $model,
                        'email_confirm',
                        $model->getEmailConfirmStatusList(),
                        array('class' => 'form-control', 'empty' => '')
                    ),
            ),
            array(
                'name'   => 'registration_date',
                'filter' => false
            ),
            array(
                'name'   => 'last_visit',
                'filter' => false
            ),
            array(
                'value' => 'yupe\helpers\Html::label($data->status, $data->getStatus(), [User::STATUS_BLOCK => yupe\helpers\Html::DANGER, User::STATUS_NOT_ACTIVE => yupe\helpers\Html::WARNING, User::STATUS_ACTIVE => yupe\helpers\Html::SUCCESS])',
                'type'  => 'raw'
            ),
            array(
                'header'      => Yii::t('UserModule.user', 'Management'),
                'class'       => 'bootstrap.widgets.TbButtonColumn',
                'template'    => '{view}{update}{password}{sendactivation}{delete}',
                'buttons'     => array(
                    'password'       => array(
                        'icon'  => 'glyphicon glyphicon-lock',
                        'label' => Yii::t('UserModule.user', 'Change password'),
                        'url'   => 'array("/user/userBackend/changepassword", "id" => $data->id)',
                    ),
                    'sendactivation' => array(
                        'label'   => Yii::t('UserModule.user', 'Send activation confirm'),
                        'url'     => 'array("/user/userBackend/sendactivation", "id" => $data->id)',
                        'icon'    => 'glyphicon glyphicon-repeat',
                        'visible' => '$data->status != User::STATUS_ACTIVE',
                        'options' => array(
                            'class' => 'user sendactivation'
                        )
                    ),
                ),
                'htmlOptions' => array(
                    'style' => 'width: 80px; text-align: right;'
                )
            ),
        ),
    )
); ?>
