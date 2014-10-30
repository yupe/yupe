<?php
$this->breadcrumbs = array(
    Yii::t('UserModule.user', 'Users')  => array('/user/userBackend/index'),
    Yii::t('UserModule.user', 'Tokens') => array('/user/tokensBackend/index'),
    Yii::t('UserModule.user', 'Update token') . ' #' . $model->id,
);

$this->pageTitle = Yii::t('UserModule.user', 'Update token') . ' #' . $model->id;

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
    array(
        'label' => Yii::t('UserModule.user', 'Token') . ' #' . $model->id,
        'items' => array(
            array(
                'icon'  => 'fa fa-fw fa-eye',
                'label' => Yii::t('UserModule.user', 'View'),
                'url'   => array('/user/tokensBackend/view', 'id' => $model->id)
            ),
            array(
                'icon'  => 'fa fa-fw fa-pencil',
                'label' => Yii::t('UserModule.user', 'Update'),
                'url'   => array('/user/tokensBackend/update', 'id' => $model->id)
            ),
            array(
                'icon'        => 'fa fa-fw fa-trash-o',
                'label'       => Yii::t('UserModule.user', 'Delete'),
                'url'         => array(
                    '/user/tokensBackend/delete',
                    'id' => $model->id
                ),
                'linkOptions' => array(
                    'ajax' => $this->getDeleteLink($model),
                )
            ),
        )
    ),
); ?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('UserModule.user', 'Tokens'); ?>
        <small><?php echo Yii::t('UserModule.user', 'update token') . ' #' . $model->id; ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
