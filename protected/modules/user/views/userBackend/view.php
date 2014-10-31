<?php
$this->breadcrumbs = array(
    Yii::t('UserModule.user', 'Users') => array('/user/userBackend/index'),
    $model->nick_name,
);

$this->pageTitle = Yii::t('UserModule.user', 'Users - show');

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
            array('label' => Yii::t('UserModule.user', 'User') . ' «' . $model->nick_name . '»'),
            array(
                'icon'  => 'fa fa-fw fa-pencil',
                'label' => Yii::t('UserModule.user', 'Edit user'),
                'url'   => array(
                    '/user/userBackend/update',
                    'id' => $model->id
                )
            ),
            array(
                'icon'  => 'fa fa-fw fa-eye',
                'label' => Yii::t('UserModule.user', 'Show user'),
                'url'   => array(
                    '/user/userBackend/view',
                    'id' => $model->id
                )
            ),
            array(
                'icon'  => 'fa fa-fw fa-lock',
                'label' => Yii::t('UserModule.user', 'Change user password'),
                'url'   => array(
                    '/user/userBackend/changepassword',
                    'id' => $model->id
                )
            ),
            array(
                'icon'        => 'fa fa-fw fa-trash-o',
                'label'       => Yii::t('UserModule.user', 'Remove user'),
                'url'         => '#',
                'linkOptions' => array(
                    'submit'  => array('/user/userBackend/delete', 'id' => $model->id),
                    'params'  => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
                    'confirm' => Yii::t('UserModule.user', 'Do you really want to remove user?')
                ),
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
        <?php echo Yii::t('UserModule.user', 'Show user'); ?><br/>
        <small>&laquo;<?php echo $model->nick_name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    array(
        'data'       => $model,
        'attributes' => array(
            'id',
            'full_name',
            'nick_name',
            'email',
            'location',
            'site',
            'birth_date',
            'about',
            array(
                'name'  => 'gender',
                'value' => $model->getGender(),
            ),
            array(
                'name'  => 'status',
                'value' => $model->getStatus(),
            ),
            array(
                'name'  => 'access_level',
                'value' => $model->getAccessLevel(),
            ),
            array(
                'name'  => 'email_confirm',
                'value' => $model->getEmailConfirmStatus(),
            ),
            'last_visit',
            'registration_date',
            'change_date'
        ),
    )
); ?>
