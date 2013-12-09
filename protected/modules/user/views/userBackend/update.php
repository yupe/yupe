<?php
    $this->breadcrumbs = array(       
        Yii::t('UserModule.user', 'Users') => array('/user/userBackend/index'),
        $model->nick_name => array('/user/userBackend/view', 'id' => $model->id),
        Yii::t('UserModule.user', 'Edit'),
    );

    $this->menu = array(
        array('label' => Yii::t('UserModule.user', 'Users'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('UserModule.user', 'Manage users'), 'url' => array('/user/userBackend/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('UserModule.user', 'Create user'), 'url' => array('/user/userBackend/create')),
            array('label' => Yii::t('UserModule.user', 'User') . ' «' . $model->nick_name . '»'),
            array('icon' => 'pencil', 'label' => Yii::t('UserModule.user', 'Edit user'), 'url' => array(
                '/user/userBackend/update',
                'id' => $model->id
            )),
            array('icon' => 'eye-open', 'label' => Yii::t('UserModule.user', 'Show user'), 'url' => array(
                '/user/userBackend/view',
                'id' => $model->id
            )),
            array('icon' => 'lock', 'label' => Yii::t('UserModule.user', 'Change user password'), 'url' => array(
                '/user/userBackend/changepassword',
                'id' => $model->id
            )),
            array('icon' => 'trash', 'label' => Yii::t('UserModule.user', 'Remove user'), 'url' => '#', 'linkOptions' => array(
                'submit' => array('/user/userBackend/delete', 'id' => $model->id),
                'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
                'confirm' => Yii::t('UserModule.user', 'Do you really want to remove user?')),
            ),
        )),
        array('label' => Yii::t('UserModule.user', 'Tokens'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('UserModule.user', 'Token list'), 'url' => array('/user/tokensBackend/index')),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('UserModule.user', 'Edit user'); ?><br />
        <small>&laquo;<?php echo $model->nick_name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>
