<?php
$this->breadcrumbs = array(
    Yii::t('UserModule.user', 'Users') => array('/user/userBackend/index'),
    Yii::t('UserModule.user', 'Create'),
);

$this->pageTitle = Yii::t('UserModule.user', 'Users - create');

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
        <?php echo Yii::t('UserModule.user', 'Users'); ?>
        <small><?php echo Yii::t('UserModule.user', 'create'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
