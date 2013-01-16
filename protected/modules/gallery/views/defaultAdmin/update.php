<?php
	$gallery = Yii::app()->getModule('gallery');
	$this->breadcrumbs = array(
		$gallery->getCategory() => array('/yupe/backend/index', 'category' => $gallery->getCategoryType() ),
        Yii::t('GalleryModule.gallery', 'Галереи') => array('/gallery/defaultAdmin/index'),
        $model->name => array('/gallery/defaultAdmin/view', 'id' => $model->id),
        Yii::t('GalleryModule.gallery', 'Редактирование'),
    );

    $this->pageTitle = Yii::t('GalleryModule.gallery', 'Галереи - редактирование');

    $this->menu = array(
        array('label' => Yii::t('GalleryModule.gallery', 'Галереи'), 'items' => array(
    		array('icon' => 'list-alt', 'label' => Yii::t('GalleryModule.gallery', 'Управление галереями'), 'url' => array('/gallery/defaultAdmin/index')),
        	array('icon' => 'plus-sign', 'label' => Yii::t('GalleryModule.gallery', 'Добавить галерею'), 'url' => array('/gallery/defaultAdmin/create')),
    	)),
        array('label' => Yii::t('GalleryModule.gallery', 'Галерея') . ' «' . mb_substr($model->name, 0, 32) . '»', 'items' => array(
	        array('icon' => 'pencil', 'label' => Yii::t('GalleryModule.gallery', 'Редактирование галереи'), 'url' => array(
	            '/gallery/defaultAdmin/update',
	            'id' => $model->id
	        )),
	        array('icon' => 'eye-open', 'label' => Yii::t('GalleryModule.gallery', 'Просмотреть галерею'), 'url' => array(
	            '/gallery/defaultAdmin/view',
	            'id' => $model->id
	        )),
	        array('icon' => 'trash', 'label' => Yii::t('GalleryModule.gallery', 'Удалить галерею'), 'url' => '#', 'linkOptions' => array(
	            'submit' => array('/gallery/defaultAdmin/delete', 'id' => $model->id),
	            'confirm' => Yii::t('GalleryModule.gallery', 'Вы уверены, что хотите удалить галерею?'),
	        )),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('GalleryModule.gallery', 'Редактирование галереи'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>