<?php
    $this->breadcrumbs = array(
        $this->module->getCategory() => array('/yupe/backend/index', 'category' => $this->module->getCategoryType() ),
        Yii::t('NewsModule.news', 'Новости') => array('/news/defaultAdmin/index'),
        Yii::t('NewsModule.news', 'Добавление'),
    );

    $this->pageTitle = Yii::t('NewsModule.news', 'Новости - добавление');

    $this->menu = array(
        array( 'label' => Yii::t('NewsModule.news', 'Новости'), 'items' => array(
        	array('icon' => 'list-alt', 'label' => Yii::t('NewsModule.news', 'Управление новостями'), 'url' => array('/news/defaultAdmin/index')),
        	array('icon' => 'plus-sign', 'label' => Yii::t('NewsModule.news', 'Добавить новость'), 'url' => array('/news/defaultAdmin/create')),
    	)),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('NewsModule.news', 'Новости'); ?>
        <small><?php echo Yii::t('NewsModule.news', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>