<?php
$this->breadcrumbs = array(
    $this->getModule('news')->getCategory() => array(''),
    Yii::t('news', 'Новости') => array('/news/default/index'),
    Yii::t('news', 'Добавление новости'),
);

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('news', 'Управление новостями'), 'url' => array('/news/default/index')),
    array('icon' => 'file', 'label' => Yii::t('news', 'Добавление новости'), 'url' => array('/news/default/create')),
);
?>
<div class="page-header">
    <h1>
        <?php echo $this->module->getName(); ?> 
        <small><?php echo Yii::t('news', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>