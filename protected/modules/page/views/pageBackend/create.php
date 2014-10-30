<?php
$this->breadcrumbs = array(
    Yii::t('PageModule.page', 'Pages') => array('/page/pageBackend/index'),
    Yii::t('PageModule.page', 'Add page'),
);

$this->pageTitle = Yii::t('PageModule.page', 'Add page');

$this->menu = array(
    array(
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('PageModule.page', 'Pages list'),
        'url'   => array('/page/pageBackend/index')
    ),
    array(
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('PageModule.page', 'Add page'),
        'url'   => array('/page/pageBackend/create')
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('PageModule.page', 'Pages'); ?>
        <small><?php echo Yii::t('PageModule.page', 'create'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial(
    '_form',
    array(
        'menuId'       => $menuId,
        'menuParentId' => $menuParentId,
        'model'        => $model,
        'pages'        => $pages,
        'languages'    => $languages
    )
); ?>
