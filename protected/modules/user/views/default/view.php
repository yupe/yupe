<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('user')->getCategory() => array(),
        Yii::t('UserModule.user', 'Пользователи') => array('/user/default/index'),
        $model->nick_name,
    );

    $this->pageTitle = Yii::t('UserModule.user', 'Пользователи - просмотр');

    $this->menu = array(
        array('label' => Yii::t('UserModule.user', 'Пользователи'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('UserModule.user', 'Управление пользователями'), 'url' => array('/user/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('UserModule.user', 'Добавление пользователя'), 'url' => array('/user/default/create')),
            array('label' => Yii::t('UserModule.user', 'Пользователь') . ' «' . $model->nick_name . '»'),
            array('icon' => 'pencil', 'label' => Yii::t('UserModule.user', 'Редактирование пользователя'), 'url' => array(
                '/user/default/update',
                'id' => $model->id
            )),
            array('icon' => 'eye-open', 'label' => Yii::t('UserModule.user', 'Просмотр пользователя'), 'url' => array(
                '/user/default/view',
                'id' => $model->id
            )),
            array('icon' => 'lock', 'label' => Yii::t('UserModule.user', 'Изменить пароль пользователя'), 'url' => array(
                '/user/default/changepassword',
                'id' => $model->id
            )),
            array('icon' => 'trash', 'label' => Yii::t('UserModule.user', 'Удалить пользователя'), 'url' => '#', 'linkOptions' => array(
                'submit' => array('/user/default/delete', 'id' => $model->id),
                'params' => array(Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken),
                'confirm' => Yii::t('UserModule.user', 'Вы уверены, что хотите удалить пользователя?')),
            ),
        )),
        array('label' => Yii::t('UserModule.user', 'Восстановления паролей'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('UserModule.user', 'Восстановления паролей'), 'url' => array('/user/recoveryPassword/index')),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('UserModule.user', 'Просмотр пользователя'); ?><br />
        <small>&laquo;<?php echo $model->nick_name; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data'       => $model,
    'attributes' => array(
        'id',
        'creation_date',
        'change_date',
        'first_name',
        'last_name',
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
        'activate_key',
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
        'registration_ip',
        'activation_ip',
    ),
)); ?>
