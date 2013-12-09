<?php
    $this->breadcrumbs = array(       
        Yii::t('PageModule.page', 'Pages') => array('/page/pageBackend/index'),
        $model->title => array('/page/pageBackend/view', 'id' => $model->id),
        Yii::t('PageModule.page', 'Edit'),
    );

    $this->pageTitle = Yii::t('PageModule.page', 'Pages - edit');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('PageModule.page', 'Pages list'), 'url' => array('/page/pageBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('PageModule.page', 'Create page'), 'url' => array('/page/pageBackend/create')),
        array('label' => Yii::t('PageModule.page', 'Article') . ' «' . mb_substr($model->title, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('PageModule.page', 'Edit page'), 'url' => array(
            '/page/pageBackend/update/',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('PageModule.page', 'View page'), 'url' => array(
            '/page/pageBackend/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('PageModule.page', 'Remove page'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/page/pageBackend/delete', 'id' => $model->id),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t('PageModule.page', 'Do you really want to remove page?'),
            'csrf' => true,
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('PageModule.page', 'Edit page'); ?><br />
        <small>&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('menuId' => $menuId, 'menuParentId' => $menuParentId,'pages' => $pages,'model' => $model, 'languages' => $languages, 'langModels' => $langModels)); ?>
