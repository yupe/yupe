<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('gallery')->getCategory() => array(),
        Yii::t('gallery', 'Галереи') => array('/gallery/default/index'),
        Yii::t('gallery', 'Добавление'),
    );

    $this->pageTitle = Yii::t('gallery', 'Галереи - добавление');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('gallery', 'Управление галлереями'), 'url' => array('/gallery/default/index')),
        array('icon' => 'plus-sign white', 'label' => Yii::t('gallery', 'Добавить галерею'), 'url' => array('/gallery/default/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('gallery', 'Галереи'); ?>
        <small><?php echo Yii::t('gallery', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>