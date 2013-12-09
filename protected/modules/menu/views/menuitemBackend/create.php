<?php
    $this->breadcrumbs = array(        
        Yii::t('MenuModule.menu', 'Menu') => array('/menu/menuBackend/index'),
        Yii::t('MenuModule.menu', 'Menu items') => array('/menu/menuitemBackend/index'),
        Yii::t('MenuModule.menu', 'Create'),
    );

    $this->pageTitle = Yii::t('MenuModule.menu', 'Menu items - create');

    $this->menu = array(
        array('label' => Yii::t('MenuModule.menu', 'Menu'), 'items' => array(
            array('icon' => 'plus-sign', 'label' => Yii::t('MenuModule.menu', 'Create menu'), 'url' => array('/menu/menuBackend/create')),
            array('icon' => 'list-alt', 'label' => Yii::t('MenuModule.menu', 'Manage menu'), 'url' => array('/menu/menuBackend/index')),
        )),
        array('label' => Yii::t('MenuModule.menu', 'Menu items'), 'items' => array(
            array('icon' => 'plus-sign', 'label' => Yii::t('MenuModule.menu', 'Create menu item'), 'url' => array('/menu/menuitemBackend/create')),
            array('icon' => 'list-alt', 'label' => Yii::t('MenuModule.menu', 'Manage menu items'), 'url' => array('/menu/menuitemBackend/index')),
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