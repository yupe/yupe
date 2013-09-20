<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('page')->getCategory() => array(),
        Yii::t('PageModule.page', 'Pages') => array('/page/default/index'),
        Yii::t('PageModule.page', 'Add page'),
    );

    $this->pageTitle = Yii::t('PageModule.page', 'Add page');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('PageModule.page', 'Pages list'), 'url' => array('/page/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('PageModule.page', 'Add page'), 'url' => array('/page/default/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('PageModule.page', 'Pages'); ?>
        <small><?php echo Yii::t('PageModule.page', 'create'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('menuId' => $menuId, 'menuParentId' => $menuParentId,'model' => $model, 'pages' => $pages, 'languages' => $languages )); ?>