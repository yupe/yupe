<?php
$this->breadcrumbs = array(
    Yii::t('UserModule.user', 'Users')  => array('/user/userBackend/index'),
    Yii::t('UserModule.user', 'Tokens') => array('/user/tokensBackend/index'),
    Yii::t('UserModule.user', 'Token management'),
);

$this->pageTitle = Yii::t('UserModule.user', 'Token management');

$this->menu = array(
    array(
        'label' => Yii::t('UserModule.user', 'Users'),
        'items' => array(
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('UserModule.user', 'Manage users'),
                'url'   => array('/user/userBackend/index')
            ),
            array(
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t('UserModule.user', 'Create user'),
                'url'   => array('/user/userBackend/create')
            ),
        )
    ),
    array(
        'label' => Yii::t('UserModule.user', 'Tokens'),
        'items' => array(
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t('UserModule.user', 'Token list'),
                'url'   => array('/user/tokensBackend/index')
            ),
        )
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('UserModule.user', 'Tokens'); ?>
        <small><?php echo Yii::t('UserModule.user', 'management'); ?></small>
    </h1>
</div>

<?php $this->renderPartial('_search', array('model' => $model)); ?>

<?php
$data = json_encode(
    array(
        Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken,
    )
);
$confirmMessage = CJavaScript::encode(
    Yii::t('UserModule.user', 'Are you sure you want to compromise this token?')
);
$compromiseJS = <<<SCRIPT
    function () {
        event.preventDefault();

        if(!confirm($confirmMessage)) return false;

        jQuery('#user-tokens-grid').yiiGridView('update', {
            type: 'POST',
            url: jQuery(this).attr('href'),
            data: $data,
        });
    }
SCRIPT;
?>

<?php $this->widget(
    'yupe\widgets\CustomGridView',
    array(
        'id'           => 'user-tokens-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'actionsButtons' => false,
        'columns'      => array(
            array(
                'name'   => 'user_id',
                'value'  => '$data->getFullName()',
                'filter' => $model->getUserList()
            ),
            array(
                'name'        => 'type',
                'value'       => '$data->getType()',
                'filter'      => $model->getTypeList(),
                'htmlOptions' => array(
                    'style' => implode(
                        ' ',
                        array(
                            'white-space: nowrap;',
                            'max-width: 150px;',
                            'text-overflow: ellipsis;',
                            'overflow: hidden;',
                        )
                    ),
                ),
            ),
            array(
                'name'        => 'token',
                'value'       => '$data->token',
                'htmlOptions' => array(
                    'style' => implode(
                        ' ',
                        array(
                            'white-space: nowrap;',
                            'max-width: 150px;',
                            'text-overflow: ellipsis;',
                            'overflow: hidden;',
                        )
                    ),
                ),
            ),
            array(
                'name'        => 'created',
                'value'       => '$data->beautifyDate($data->created)',
                'filter'      => false,
                'htmlOptions' => array(
                    'style' => 'width: 120px;'
                )
            ),
            array(
                'name'        => 'updated',
                'filter'      => false,
                'value'       => '$data->beautifyDate($data->updated)',
                'htmlOptions' => array(
                    'style' => 'width: 120px;'
                )
            ),
            array(
                'name'        => 'expire',
                'filter'      => false,
                'value'       => '$data->beautifyDate($data->expire)',
                'htmlOptions' => array(
                    'style' => 'width: 120px;'
                )
            ),
            array(
                'name'        => 'status',
                'value'       => 'yupe\helpers\Html::label($data->status, $data->getStatus(), [UserToken::STATUS_NEW => yupe\helpers\Html::SUCCESS, UserToken::STATUS_ACTIVATE => yupe\helpers\Html::INFO, UserToken::STATUS_FAIL => yupe\helpers\Html::DANGER])',
                'type'        => 'raw',
                'filter'      => $model->getStatusList(),
                'htmlOptions' => array(
                    'style' => implode(
                        ' ',
                        array(
                            'white-space: nowrap;',
                            'max-width: 100px;',
                            'text-overflow: ellipsis;',
                            'overflow: hidden;',
                        )
                    ),
                ),
            ),
            array(
                'header'      => Yii::t('UserModule.user', 'Management'),
                'class'       => 'yupe\widgets\CustomButtonColumn',
                'template'    => "{fail} &emsp; {view} {update} {delete}",
                'buttons'     => array(
                    'fail' => array(
                        'icon'    => 'fa fa-fw fa-times',
                        'label'   => Yii::t('UserModule.user', 'Compromise'),
                        'click'   => $compromiseJS,
                        'visible' => '$data->getIsCompromised() === false',
                        'url'     => 'array("/user/tokensBackend/compromise", "id" => $data->id)',
                    ),
                ),
                'htmlOptions' => array(
                    'style' => 'width: 90px; text-align: right; white-space: nowrap;'
                )
            ),
        ),
    )
); ?>
