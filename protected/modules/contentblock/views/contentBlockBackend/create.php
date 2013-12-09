<?php
    $this->breadcrumbs = array(       
        Yii::t('ContentBlockModule.contentblock', 'Content blocks') => array('/contentblock/contentBlockBackend/index'),
        Yii::t('ContentBlockModule.contentblock', 'Adding new content block'),
    );

    $this->pageTitle = Yii::t('ContentBlockModule.contentblock', 'Content blocks - add');

    $this->menu = array(
        array('icon' => 'list-alt','label' => Yii::t('ContentBlockModule.contentblock', 'Content blocks administration'), 'url' => array('/contentblock/contentBlockBackend/index')),
        array('icon' => 'plus-sign','label' => Yii::t('ContentBlockModule.contentblock', 'Add content block'), 'url' => array('/contentblock/contentBlockBackend/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ContentBlockModule.contentblock', 'Content blocks'); ?>
        <small><?php echo Yii::t('ContentBlockModule.contentblock', 'add'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>