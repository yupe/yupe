<?php
    $this->breadcrumbs = array(
        $this->module->getCategory() => array('/yupe/backend/index', 'category' => $this->module->getCategoryType()),
        Yii::t('PageModule.page', 'Страницы') => array('/page/defaultAdmin/index'),
        Yii::t('PageModule.page', 'Добавление страницы'),
    );

    $this->pageTitle = Yii::t('PageModule.page', 'Добавление страницы');

    $this->menu = array(
        array('label' => Yii::t('PageModule.page', 'Страницы'), 'items' => array(
            array('icon' => 'list-alt', 'label' => Yii::t('PageModule.page', 'Управление страницами'), 'url' => array('/page/defaultAdmin/index')),
            array('icon' => 'plus-sign', 'label' => Yii::t('PageModule.page', 'Добавление страницы'), 'url' => array('/page/defaultAdmin/create')),
       ))
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('PageModule.page', 'Страницы'); ?>
        <small><?php echo Yii::t('PageModule.page', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model, 'pages' => $pages)); ?>