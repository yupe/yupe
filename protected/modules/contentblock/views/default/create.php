<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('contentblock')->getCategory() => array(''),
        Yii::t('ContentBlockModule.contentblock', 'Блоки контента') => array('/contentblock/default/index'),
        Yii::t('ContentBlockModule.contentblock', 'Добавление нового блока'),
    );

    $this->pageTitle = Yii::t('ContentBlockModule.contentblock', 'Блоки контента - добавление');

    $this->menu = array(
        array('icon' => 'list-alt','label' => Yii::t('ContentBlockModule.contentblock', 'Управление блоками контента'), 'url' => array('/contentblock/default/index')),
        array('icon' => 'plus-sign','label' => Yii::t('ContentBlockModule.contentblock', 'Добавить блок контента'), 'url' => array('/contentblock/default/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ContentBlockModule.contentblock', 'Блоки контента'); ?>
        <small><?php echo Yii::t('ContentBlockModule.contentblock', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>