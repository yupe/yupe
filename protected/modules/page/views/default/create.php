<?php
    $this->breadcrumbs = array(
        $this->getModule('page')->getCategory() => array('/page/default/index'),
        Yii::t('page', 'Страницы') => array('/page/default/index'),
        Yii::t('page', 'Добавление страницы'),
    );
    
    $this->pageTitle = Yii::t('page', 'Добавление страницы');
    
    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('page', 'Управление страницами'), 'url' => array('/page/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('page', 'Добавление страницы'), 'url' => array('/page/default/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('page', 'Страницы'); ?>
        <small><?php echo Yii::t('page', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model, 'pages' => $pages)); ?>