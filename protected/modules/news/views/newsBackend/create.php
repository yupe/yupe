<?php
    $this->breadcrumbs = array(        
        Yii::t('NewsModule.news', 'News') => array('/news/newsBackend/index'),
        Yii::t('NewsModule.news', 'Create'),
    );

    $this->pageTitle = Yii::t('NewsModule.news', 'News - create');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('NewsModule.news', 'News management'), 'url' => array('/news/newsBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('NewsModule.news', 'Create article'), 'url' => array('/news/newsBackend/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('NewsModule.news', 'News'); ?>
        <small><?php echo Yii::t('NewsModule.news', 'create'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model, 'languages' => $languages )); ?>