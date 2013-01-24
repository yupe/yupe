<?php
    $this->breadcrumbs = array(
        $this->module->getCategory() => array('/yupe/backend/index', 'category' => $this->module->getCategoryType()),
        Yii::t('UserModule.user', 'Пользователи') => array('/user/defaultAdmin/index'),
        Yii::t('UserModule.user', 'Добавление'),
    );

    $this->pageTitle = Yii::t('UserModule.user', 'Пользователи - добавление');

    $this->menu = array(
        array('label' => Yii::t('UserModule.user', 'Пользователи'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('UserModule.user', 'Управление пользователями'), 'url' => array('/user/defaultAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('UserModule.user', 'Добавление пользователя'), 'url' => array('/user/defaultAdmin/create')),
        )),
        array('label' => Yii::t('UserModule.user', 'Восстановления паролей'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('UserModule.user', 'Восстановления паролей'), 'url' => array('/user/recoveryPasswordAdmin/index')),
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