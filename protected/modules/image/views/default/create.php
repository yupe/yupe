<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('image')->getCategory() => array(),
        Yii::t('ImageModule.image', 'Изображения') => array('/image/default/index'),
        Yii::t('ImageModule.image', 'Добавление'),
    );

    $this->pageTitle = Yii::t('ImageModule.image', 'Изображения - добавление');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('ImageModule.image', 'Управление изображениями'), 'url' => array('/image/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('ImageModule.image', 'Добавить изображение'), 'url' => array('/image/default/create')),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ImageModule.image', 'Изображения'); ?>
        <small><?php echo Yii::t('ImageModule.image', 'добавление'); ?></small>
    </h1>
</div>

<?php echo  $this->renderPartial('_form', array('model' => $model)); ?>