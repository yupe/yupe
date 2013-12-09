<?php
    $this->breadcrumbs = array(        
        Yii::t('UserModule.user', 'Users') => array('/user/userBackend/index'),
        Yii::t('UserModule.user', 'Tokens') => array('/user/tokensBackend/index'),
        Yii::t('UserModule.user', 'Token management'),
    );

    $this->pageTitle = Yii::t('UserModule.user', 'Token management');

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
        <?php echo Yii::t('UserModule.user', 'Tokens'); ?>
        <small><?php echo Yii::t('UserModule.user', 'management'); ?></small>
    </h1>
</div>

<?php $this->renderPartial('_search', array('model' => $model)); ?>

<p><?php echo Yii::t('UserModule.user', 'This section represents token management!'); ?></p>

<?php
$data = json_encode(
    array(
        Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken,
    )
);
$confirmMessage = CJavaScript::encode(
    Yii::t('UserModule.user', 'Are you sure you want to compromise this token?')
);
$compromiseJS   = <<<SCRIPT
    function() {
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
    'yupe\widgets\CustomGridView', array(
        'id'            => 'user-tokens-grid',
        'type'         => 'condensed',
        'dataProvider' => $model->search(),
        'ajaxType'     => 'POST',
        'columns'      => array(
            'id',
            array(
                'name'        => 'user_id',
                'value'       => '$data->getFullName()',
            ),
            array(
                'name'        => 'status',
                'value'       => '$data->getStatus()',
                'htmlOptions' => array(
                    'style'  => implode(
                        ' ', array(
                            'white-space: nowrap;',
                            'max-width: 100px;',
                            'text-overflow: ellipsis;',
                            'overflow: hidden;',
                        )
                    ),
                ),
            ),
            array(
                'name'        => 'type',
                'value'       => '$data->getType()',
                'htmlOptions' => array(
                    'style'  => implode(
                        ' ', array(
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
                    'style'  => implode(
                        ' ', array(
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
                'htmlOptions' => array(
                    'style'   => 'width: 120px;'
                )
            ),
            array(
                'name'        => 'updated',
                'value'       => '$data->beautifyDate($data->updated)',
                'htmlOptions' => array(
                    'style'   => 'width: 120px;'
                )
            ),
            array(
                'header'   => Yii::t('UserModule.user', 'Management'),
                'class'    => 'bootstrap.widgets.TbButtonColumn',
                'template' => "{fail} &emsp; {view} {update} {delete}",
                'buttons'  => array(
                    'fail' => array(
                        'icon'        => 'remove',
                        'label'       => Yii::t('UserModule.user', 'Compromise'),
                        'click'       => $compromiseJS,
                        'visible'     => '$data->getIsCompromised() === false',
                        'url'         => 'array("/user/tokensBackend/compromise", "id" => $data->id)',
                    ),
                ),
                'htmlOptions' => array(
                    'style'   => 'width: 90px; text-align: right;'
                )
            ),
        ),
    )
); ?>
