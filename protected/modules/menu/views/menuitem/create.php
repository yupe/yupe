<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('menu')->getCategory() => array(),
        Yii::t('MenuModule.menu', 'Menu') => array('/menu/menu/index'),
        Yii::t('MenuModule.menu', 'Menu items') => array('/menu/menuitem/index'),
        Yii::t('MenuModule.menu', 'Create'),
    );

    $this->pageTitle = Yii::t('MenuModule.menu', 'Menu items - create');

    $this->menu = array(
        array('label' => Yii::t('MenuModule.menu', 'Menu'), 'items' => array(
            array('icon' => 'plus-sign', 'label' => Yii::t('MenuModule.menu', 'Create menu'), 'url' => array('/menu/menu/create')),
            array('icon' => 'list-alt', 'label' => Yii::t('MenuModule.menu', 'Manage menu'), 'url' => array('/menu/menu/index')),
        )),
        array('label' => Yii::t('MenuModule.menu', 'Menu items'), 'items' => array(
            array('icon' => 'plus-sign', 'label' => Yii::t('MenuModule.menu', 'Create menu item'), 'url' => array('/menu/menuitem/create')),
            array('icon' => 'list-alt', 'label' => Yii::t('MenuModule.menu', 'Manage menu items'), 'url' => array('/menu/menuitem/index')),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('MenuModule.menu', 'Menu item'); ?>
        <small><?php echo Yii::t('MenuModule.menu', 'create'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>