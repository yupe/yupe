<?php
    $image = Yii::app()->getModule('image');
    $this->breadcrumbs = array(
    	$image->getCategory() => array('/yupe/backend/index', 'category' => $image->getCategoryType() ),
        Yii::t('ImageModule.image', 'Изображения') => array('/image/defaultAdmin/index'),
        $model->name => array('/image/defaultAdmin/view', 'id' => $model->id),
        Yii::t('ImageModule.image', 'Редактирование'),
    );

    $this->pageTitle = Yii::t('ImageModule.image', 'Изображения - редактирование');

    $this->menu = array(
        array('label' => Yii::t('ImageModule.image', 'Изображения'), 'items' => array(
        	array('icon' => 'list-alt', 'label' => Yii::t('ImageModule.image', 'Управление изображениями'), 'url' => array('/image/defaultAdmin/index')),
        	array('icon' => 'plus-sign', 'label' => Yii::t('ImageModule.image', 'Добавить изображение'), 'url' => array('/image/defaultAdmin/create')),
    	)),
        array('label' => Yii::t('ImageModule.image', 'Изображение') . ' «' . mb_substr($model->name, 0, 32) . '»', 'items' => array( 
	        array('icon' => 'pencil', 'label' => Yii::t('ImageModule.image', 'Редактирование изображение'), 'url' => array(
	            '/image/defaultAdmin/update',
	            'id' => $model->id
	        )),
	        array('icon' => 'eye-open', 'label' => Yii::t('ImageModule.image', 'Просмотреть изображение'), 'url' => array(
	            '/image/defaultAdmin/view',
	            'id' => $model->id
	        )),
	        array('icon' => 'trash', 'label' => Yii::t('ImageModule.image', 'Удалить изображение'),'url' => '#', 'linkOptions' => array(
	            'submit'  => array('/image/defaultAdmin/delete', 'id' => $model->id),
	            'confirm' => Yii::t('yupe', 'Вы уверены, что хотите удалить изображение?'),
	        )),
        )),
    );
?>
<div class="page-header">
    <h1><?php echo Yii::t('ImageModule.image', 'Редактирование изображения'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>