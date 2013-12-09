<?php
    $this->breadcrumbs = array(       
        Yii::t('MenuModule.menu', 'Menu') => array('/menu/menuBackend/index'),
        Yii::t('MenuModule.menu', 'Menu items') => array('/menu/menuitemBackend/index'),
        $model->title => array('/menu/menuitemBackend/view', 'id' => $model->id),
        Yii::t('MenuModule.menu', 'Edit'),
    );

    $this->pageTitle = Yii::t('MenuModule.menu', 'Menu items - edit');

    $this->menu = array(
        array('label' => Yii::t('MenuModule.menu', 'Menu'), 'items' => array(
            array('icon' => 'plus-sign', 'label' => Yii::t('MenuModule.menu', 'Create menu'), 'url' => array('/menu/menuBackend/create')),
            array('icon' => 'list-alt', 'label' => Yii::t('MenuModule.menu', 'Manage menu'), 'url' => array('/menu/menuBackend/index')),
        )),
        array('label' => Yii::t('MenuModule.menu', 'Menu items'), 'items' => array(
            array('icon' => 'plus-sign', 'label' => Yii::t('MenuModule.menu', 'Create menu item'), 'url' => array('/menu/menuitemBackend/create')),
            array('icon' => 'list-alt', 'label' => Yii::t('MenuModule.menu', 'Manage menu items'), 'url' => array('/menu/menuitemBackend/index')),
            array('label' => Yii::t('MenuModule.menu', 'Menu item') . ' «' . $model->title . '»'),
            array('icon' => 'pencil', 'label' => Yii::t('MenuModule.menu', 'Change menu item'), 'url' => array(
                '/menu/menuitemBackend/update',
                'id' => $model->id
            )),
            array('icon' => 'eye-open', 'label' => Yii::t('MenuModule.menu', 'View menu item'), 'url' => array(
                '/menu/menuitemBackend/view',
                'id' => $model->id
            )),
            array('icon' => 'trash', 'label' => Yii::t('MenuModule.menu', 'Remove menu item'), 'url' => '#', 'linkOptions' => array(
                'submit' => array('/menu/menuitemBackend/delete', 'id' => $model->id),
                'confirm' => Yii::t('MenuModule.menu', 'Do you really want to remove menu item?')),
            ),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('MenuModule.menu', 'Edit menu item'); ?><br />
        <small>&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>