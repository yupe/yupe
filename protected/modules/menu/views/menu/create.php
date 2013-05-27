<?php
/**
 * Файл представления menu/create:
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
    Yii::t('MenuModule.menu', 'Добавление'),
);

$this->pageTitle = Yii::t('MenuModule.menu', 'Меню - добавление');

$this->menu = array(
    array(
        'label' => Yii::t('MenuModule.menu', 'Меню'), 'items' => array(
            array('icon' => 'plus-sign', 'label' => Yii::t('MenuModule.menu', 'Добавить меню'), 'url' => array('/menu/menu/create')),
            array('icon' => 'list-alt', 'label' => Yii::t('MenuModule.menu', 'Управление меню'), 'url' => array('/menu/menu/index')),
        )
    ),
    array(
        'label' => Yii::t('MenuModule.menu', 'Пункты меню'), 'items' => array(
            array('icon' => 'plus-sign', 'label' => Yii::t('MenuModule.menu', 'Добавить пункт меню'), 'url' => array('/menu/menuitem/create')),
            array('icon' => 'list-alt', 'label' => Yii::t('MenuModule.menu', 'Управление пунктами меню'), 'url' => array('/menu/menuitem/index')),
        )
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('MenuModule.menu', 'Меню'); ?>
        <small><?php echo Yii::t('MenuModule.menu', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>