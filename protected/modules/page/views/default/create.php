<?php $this->pageTitle = Yii::t('page', 'Добавление страницы'); ?>

<?php
$this->breadcrumbs = array(
    $this->getModule('page')->getCategory() => array('admin'),
    Yii::t('page', 'Страницы') => array('admin'),
    Yii::t('page', 'Добавление страницы'),
);

$this->menu = array(
    array( 'icon' => 'list-alt', 'label' => Yii::t('page', 'Управление страницами'), 'url' => array('admin')),
    array( 'icon' => 'file white', 'label' => Yii::t('page', 'Добавление страницы'), 'url' => array('/page/default/create')),
);
?>
<div class="page-header">
    <h1><?php echo $this->module->getName(); ?>
        <small><?php echo Yii::t('page', 'добавление новой'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model, 'pages' => $pages)); ?>