<?php
	$gallery = Yii::app()->getModule('gallery');
	$this->breadcrumbs = array(
		$gallery->getCategory() => array('/yupe/backend/index', 'category' => $gallery->getCategoryType() ),
        Yii::t('GalleryModule.gallery', 'Галереи') => array('/gallery/defaultAdmin/index'),
        Yii::t('GalleryModule.gallery', 'Добавление'),
    );

    $this->pageTitle = Yii::t('GalleryModule.gallery', 'Галереи - добавление');

    $this->menu = array(
        array('label' => Yii::t('GalleryModule.gallery', 'Галереи'), 'items' => array(
    		array('icon' => 'list-alt', 'label' => Yii::t('GalleryModule.gallery', 'Управление галереями'), 'url' => array('/gallery/defaultAdmin/index')),
        	array('icon' => 'plus-sign', 'label' => Yii::t('GalleryModule.gallery', 'Добавить галерею'), 'url' => array('/gallery/defaultAdmin/create')),
    	)),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('GalleryModule.gallery', 'Галереи'); ?>
        <small><?php echo Yii::t('GalleryModule.gallery', 'добавление'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>