<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('user')->getCategory() => array(),
        Yii::t('UserModule.user', 'Users') => array('/user/default/index'),
        $model->nick_name => array('/user/default/view', 'id' => $model->id),
        Yii::t('UserModule.user', 'Edit'),
    );

    $this->menu = array(
        array('label' => Yii::t('UserModule.user', 'Users'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('UserModule.user', 'Manage users'), 'url' => array('/user/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('UserModule.user', 'Create user'), 'url' => array('/user/default/create')),
            array('label' => Yii::t('UserModule.user', 'User') . ' «' . $model->nick_name . '»'),
            array('icon' => 'pencil', 'label' => Yii::t('UserModule.user', 'Edit user'), 'url' => array(
                '/user/default/update',
                'id' => $model->id
            )),
            array('icon' => 'eye-open', 'label' => Yii::t('UserModule.user', 'Show user'), 'url' => array(
                '/user/default/view',
                'id' => $model->id
            )),
            array('icon' => 'lock', 'label' => Yii::t('UserModule.user', 'Change user password'), 'url' => array(
                '/user/default/changepassword',
                'id' => $model->id
            )),
            array('icon' => 'trash', 'label' => Yii::t('UserModule.user', 'Remove user'), 'url' => '#', 'linkOptions' => array(
                'submit' => array('/user/default/delete', 'id' => $model->id),
                'params' => array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken),
                'confirm' => Yii::t('UserModule.user', 'Do you really want to remove user?')),
            ),
        )),
        array('label' => Yii::t('UserModule.user', 'Passwords recovery!'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('UserModule.user', 'Passwords recovery!'), 'url' => array('/user/recoveryPassword/index')),
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
