<?php
    $contentblock = Yii::app()->getModule('contentblock');
    $this->breadcrumbs = array(
        $contentblock->getCategory() => array('/yupe/backend/index', 'category' => $contentblock->getCategoryType() ),
        Yii::t('ContentBlockModule.contentblock', 'Блоки контента') => array('/contentblock/defaultAdmin/index'),
        Yii::t('ContentBlockModule.contentblock', 'Добавление нового блока'),
    );

    $this->pageTitle = Yii::t('ContentBlockModule.contentblock', 'Блоки контента - добавление');

    $this->menu = array(
        array('icon' => 'list-alt','label' => Yii::t('ContentBlockModule.contentblock', 'Управление блоками контента'), 'url' => array('/contentblock/defaultAdmin/index')),
        array('icon' => 'plus-sign','label' => Yii::t('ContentBlockModule.contentblock', 'Добавить блок контента'), 'url' => array('/contentblock/defaultAdmin/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ContentBlockModule.contentblock', 'Блоки контента'); ?>
        <small><?php echo Yii::t('ContentBlockModule.contentblock', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>