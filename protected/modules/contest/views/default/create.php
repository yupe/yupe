<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('contest')->getCategory() => array(),
        Yii::t('contest', 'Конкурсы') => array('/contest/default/index'),
        Yii::t('contest', 'Добавление'),
    );

    $this->pageTitle = Yii::t('contest', 'Конкурсы - добавление');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('contest', 'Управление конкурсами'), 'url' => array('/contest/default/index')),
        array('icon' => 'plus-sign white', 'label' => Yii::t('contest', 'Добавить конкурс'), 'url' => array('/contest/default/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('contest', 'Конкурсы'); ?>
        <small><?php echo Yii::t('contest', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>