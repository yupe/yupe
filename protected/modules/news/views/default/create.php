<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('news')->getCategory() => array(),
        Yii::t('NewsModule.news', 'News') => array('/news/default/index'),
        Yii::t('NewsModule.news', 'Create'),
    );

    $this->pageTitle = Yii::t('NewsModule.news', 'News - create');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('NewsModule.news', 'News management'), 'url' => array('/news/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('NewsModule.news', 'Create article'), 'url' => array('/news/default/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('NewsModule.news', 'News'); ?>
        <small><?php echo Yii::t('NewsModule.news', 'create'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model, 'languages' => $languages )); ?>