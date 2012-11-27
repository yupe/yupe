<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('menu')->getCategory() => array(),
        Yii::t('menu', 'Меню') => array('/menu/menu/index'),
        $model->name => array('/menu/menu/view', 'id' => $model->id),
        Yii::t('menu', 'Редактирование'),
    );

    $this->pageTitle = Yii::t('menu', 'Меню - редактирование');

    $this->menu = array(
        array('label' => Yii::t('menu', 'Меню'), 'items' => array(
            array('icon' => 'plus-sign', 'label' => Yii::t('menu', 'Добавить меню'), 'url' => array('/menu/menu/create')),
            array('icon' => 'list-alt', 'label' => Yii::t('menu', 'Управление меню'), 'url' => array('/menu/menu/index')),
            array('label' => Yii::t('blog', 'Меню') . ' «' . $model->name . '»'),
            array('icon' => 'pencil', 'label' => Yii::t('menu', 'Изменить меню'), 'url' => array('/menu/menu/update', 'id' => $model->id)),
            array('icon' => 'eye-open', 'encodeLabel' => false, 'label' => Yii::t('blog', 'Просмотреть меню'), 'url' => array(
                '/menu/menu/view',
                'id' => $model->id
            )),
            array('icon' => 'trash', 'label' => Yii::t('menu', 'Удалить меню'), 'url' => '#', 'linkOptions' => array(
                'submit' => array('/menu/menu/delete', 'id' => $model->id),
                'confirm' => Yii::t('menu', 'Подтверждаете удаление?')),
            ),
        )),
        array('label' => Yii::t('menu', 'Пункты меню'), 'items' => array(
            array('icon' => 'plus-sign', 'label' => Yii::t('menu', 'Добавить пункт меню'), 'url' => array('/menu/menuitem/create')),
            array('icon' => 'list-alt', 'label' => Yii::t('menu', 'Управление пунктами меню'), 'url' => array('/menu/menuitem/index')),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('blog', 'Редактирование меню'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>