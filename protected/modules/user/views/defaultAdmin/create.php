<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('user')->getCategory() => array(),
        Yii::t('UserModule.user', 'Пользователи') => array('/admin/user'),
        Yii::t('UserModule.user', 'Добавление'),
    );

    $this->pageTitle = Yii::t('UserModule.user', 'Пользователи - добавление');

    $this->menu = array(
        array('label' => Yii::t('UserModule.user', 'Пользователи'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('UserModule.user', 'Управление пользователями'), 'url' => array('/admin/user')),
            array('icon' => 'plus-sign', 'label' => Yii::t('UserModule.user', 'Добавление пользователя'), 'url' => array('/admin/user/create')),
        )),
        array('label' => Yii::t('UserModule.user', 'Восстановления паролей'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('UserModule.user', 'Восстановления паролей'), 'url' => array('/admin/user/recoveryPassword/index')),
        )),
    );
?>

<div class="page-header">
    <h1>
        <?php echo Yii::t('UserModule.user', 'Пользователи'); ?>
        <small><?php echo Yii::t('UserModule.user', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>