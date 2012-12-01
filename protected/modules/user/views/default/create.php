<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('user')->getCategory() => array(),
        Yii::t('user', 'Пользователи') => array('/user/default/index'),
        Yii::t('user', 'Добавление'),
    );

    $this->pageTitle = Yii::t('user', 'Пользователи - добавление');

    $this->menu = array(
        array('label' => Yii::t('user', 'Пользователи'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('user', 'Управление пользователями'), 'url' => array('/user/default/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('user', 'Добавление пользователя'), 'url' => array('/user/default/create')),
        )),
        array('label' => Yii::t('user', 'Восстановления паролей'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('user', 'Восстановления паролей'), 'url' => array('/user/recoveryPassword/index')),
        )),
    );
?>

<div class="page-header">
    <h1>
        <?php echo Yii::t('user', 'Пользователи'); ?>
        <small><?php echo Yii::t('user', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>