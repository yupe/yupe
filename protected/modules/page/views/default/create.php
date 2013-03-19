<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('page')->getCategory() => array(),
        Yii::t('PageModule.page', 'Страницы') => array('/page/default/index'),
        Yii::t('PageModule.page', 'Добавление страницы'),
    );

    $this->pageTitle = Yii::t('PageModule.page', 'Добавление страницы');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('PageModule.page', 'Список страниц'), 'url' => array('/page/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('PageModule.page', 'Добавление страницы'), 'url' => array('/page/default/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('PageModule.page', 'Страницы'); ?>
        <small><?php echo Yii::t('PageModule.page', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model, 'pages' => $pages, 'languages' => $languages )); ?>