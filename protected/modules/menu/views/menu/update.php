<?php
/**
 * Файл представления menu/update:
 *
 * @category YupeViews
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://yupe.ru
 *
 **/
$this->breadcrumbs = array(
    Yii::app()->getModule('menu')->getCategory() => array(),
    Yii::t('MenuModule.menu', 'Меню') => array('/menu/menu/index'),
    $model->name => array('/menu/menu/view', 'id' => $model->id),
    Yii::t('MenuModule.menu', 'Редактирование'),
);

$this->pageTitle = Yii::t('MenuModule.menu', 'Меню - редактирование');

$this->menu = array(
    array(
        'label' => Yii::t('MenuModule.menu', 'Меню'), 'items' => array(
            array('icon' => 'plus-sign', 'label' => Yii::t('MenuModule.menu', 'Добавить меню'), 'url' => array('/menu/menu/create')),
            array('icon' => 'list-alt', 'label' => Yii::t('MenuModule.menu', 'Управление меню'), 'url' => array('/menu/menu/index')),
            array('label' => Yii::t('blog', 'Меню') . ' «' . $model->name . '»'),
            array(
                'icon' => 'pencil', 'label' => Yii::t('MenuModule.menu', 'Редактировать меню'), 'url' => array(
                    '/menu/menu/update',
                    'id' => $model->id
                )
            ),
            array(
                'icon' => 'eye-open', 'label' => Yii::t('blog', 'Просмотреть меню'), 'url' => array(
                    '/menu/menu/view',
                    'id' => $model->id
                )
            ),
            array(
                'icon' => 'trash', 'label' => Yii::t('MenuModule.menu', 'Удалить меню'), 'url' => '#', 'linkOptions' => array(
                    'submit' => array('/menu/menu/delete', 'id' => $model->id),
                    'confirm' => Yii::t('MenuModule.menu', 'Вы уверены, что хотите удалить меню?')
                ),
            ),
        )
    ),
    array(
        'label' => Yii::t('MenuModule.menu', 'Пункты меню'), 'items' => array(
            array('icon' => 'plus-sign', 'label' => Yii::t('MenuModule.menu', 'Добавить пункт меню'), 'url' => array('/menu/menuitem/create')),
            array('icon' => 'list-alt', 'label' => Yii::t('MenuModule.menu', 'Управление пунктами меню'), 'url' => array('/menu/menuitem/index')),
        )
    ),
); ?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('MenuModule.menu', 'Редактирование меню'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>