<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('menu')->getCategory() => array(),
        Yii::t('MenuModule.menu', 'Меню') => array('/menu/menu/index'),
        Yii::t('MenuModule.menu', 'Пункты меню') => array('/menu/menuitem/index'),
        $model->title => array('/menu/menuitem/view', 'id' => $model->id),
        Yii::t('MenuModule.menu', 'Редактирование'),
    );

    $this->pageTitle = Yii::t('MenuModule.menu', 'Пункты меню - редактирование');

    $this->menu = array(
        array('label' => Yii::t('MenuModule.menu', 'Меню'), 'items' => array(
            array('icon' => 'plus-sign', 'label' => Yii::t('MenuModule.menu', 'Добавить меню'), 'url' => array('/menu/menu/create')),
            array('icon' => 'list-alt', 'label' => Yii::t('MenuModule.menu', 'Управление меню'), 'url' => array('/menu/menu/index')),
        )),
        array('label' => Yii::t('MenuModule.menu', 'Пункты меню'), 'items' => array(
            array('icon' => 'plus-sign', 'label' => Yii::t('MenuModule.menu', 'Добавить пункт меню'), 'url' => array('/menu/menuitem/create')),
            array('icon' => 'list-alt', 'label' => Yii::t('MenuModule.menu', 'Управление пунктами меню'), 'url' => array('/menu/menuitem/index')),
            array('label' => Yii::t('blog', 'Пункт меню') . ' «' . $model->title . '»'),
            array('icon' => 'pencil', 'label' => Yii::t('MenuModule.menu', 'Изменить пункт меню'), 'url' => array(
                '/menu/menuitem/update',
                'id' => $model->id
            )),
            array('icon' => 'eye-open', 'label' => Yii::t('blog', 'Просмотреть пункт меню'), 'url' => array(
                '/menu/menuitem/view',
                'id' => $model->id
            )),
            array('icon' => 'trash', 'label' => Yii::t('MenuModule.menu', 'Удалить пункт меню'), 'url' => '#', 'linkOptions' => array(
                'submit' => array('/menu/menuitem/delete', 'id' => $model->id),
                'confirm' => Yii::t('MenuModule.menu', 'Вы уверены, что хотите удалить пункт меню?')),
            ),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('MenuModule.menu', 'Редактирование пункта меню'); ?><br />
        <small>&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>