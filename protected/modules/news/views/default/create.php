<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('news')->getCategory() => array(),
        Yii::t('news', 'Новости') => array('/news/default/index'),
        Yii::t('news', 'Добавление'),
    );

    $this->pageTitle = Yii::t('news', 'Новости - добавление');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('news', 'Управление новостями'), 'url' => array('/news/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('news', 'Добавить новость'), 'url' => array('/news/default/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('news', 'Новости'); ?> 
        <small><?php echo Yii::t('news', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>