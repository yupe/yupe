<?php
$this->breadcrumbs = array(
    Yii::t('UserModule.user', 'Users')  => array('/user/userBackend/index'),
    Yii::t('UserModule.user', 'Tokens') => array('/user/tokensBackend/index'),
    Yii::t('UserModule.user', 'Create token'),
);

$this->pageTitle = Yii::t('UserModule.user', 'Create token');

$this->menu = array(
    array(
        'label' => Yii::t('UserModule.user', 'Users'),
        'items' => array(
            array(
                'icon'  => 'list-alt',
                'label' => Yii::t('UserModule.user', 'Manage users'),
                'url'   => array('/user/userBackend/index')
            ),
            array(
                'icon'  => 'plus-sign',
                'label' => Yii::t('UserModule.user', 'Create user'),
                'url'   => array('/user/userBackend/create')
            ),
        )
    ),
    array(
        'label' => Yii::t('UserModule.user', 'Tokens'),
        'items' => array(
            array(
                'icon'  => 'list-alt',
                'label' => Yii::t('UserModule.user', 'Token list'),
                'url'   => array('/user/tokensBackend/index')
            ),
            array(
                'icon'  => 'plus-sign',
                'label' => Yii::t('UserModule.user', 'Create token'),
                'url'   => array('/user/tokensBackend/create')
            ),
        )
    ),
); ?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('UserModule.user', 'Tokens'); ?>
        <small><?php echo Yii::t('UserModule.user', 'create token'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
