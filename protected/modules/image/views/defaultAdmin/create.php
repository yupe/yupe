<?php
    $image = Yii::app()->getModule('image');
    $this->breadcrumbs = array(
    	$image->getCategory() => array('/yupe/backend/index', 'category' => $image->getCategoryType() ),
        Yii::t('ImageModule.image', 'Изображения') => array('/image/defaultAdmin/index'),
        Yii::t('ImageModule.image', 'Добавление'),
    );

    $this->pageTitle = Yii::t('ImageModule.image', 'Изображения - добавление');

    $this->menu = array(
        array('label' => Yii::t('ImageModule.image', 'Изображения'), 'items' => array(
        	array('icon' => 'list-alt', 'label' => Yii::t('ImageModule.image', 'Управление изображениями'), 'url' => array('/image/defaultAdmin/index')),
        	array('icon' => 'plus-sign', 'label' => Yii::t('ImageModule.image', 'Добавить изображение'), 'url' => array('/image/defaultAdmin/create')),
    	)),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('ImageModule.image', 'Изображения'); ?>
        <small><?php echo Yii::t('ImageModule.image', 'добавление'); ?></small>
    </h1>
</div>

<?php echo  $this->renderPartial('_form', array('model' => $model)); ?>