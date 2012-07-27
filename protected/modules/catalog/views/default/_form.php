<?php $form=$this->beginWidget('bootstrap.widgets.BootActiveForm',array(
	'id'=>'good-form',
	'enableAjaxValidation'=>false,
	'type'=>'vertical',
    'htmlOptions' => array('class' => 'well form-vertical','enctype' => 'multipart/form-data')
)); ?>

<div class="alert alert-info"><?php echo Yii::t('yupe','Поля, отмеченные');?> <span class="required">*</span> <?php echo Yii::t('yupe','обязательны.');?></div>

	<?php echo  $form->errorSummary($model); ?>

	<div class='row-fluid control-group <?php echo $model->hasErrors("category_id")?"error":"" ?>'><?php echo  $form->dropDownList($model,'category_id',CHtml::listData(Category::model()->findAll(),'id','name'),array('empty' => Yii::t('catalog','--выберите--'))); ?></div>

	<div class='row-fluid control-group <?php echo $model->hasErrors("name")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>150,'size' => 60)); ?></div>

	<div class='row-fluid control-group <?php echo $model->hasErrors("alias")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'alias',array('class'=>'span5','maxlength'=>100,'size' => 60)); ?></div>

	<div class='row-fluid control-group <?php echo $model->hasErrors("price")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'price',array('class'=>'span5','size' => 60,'maxlength' => 60)); ?></div>

	<div class='row-fluid control-group <?php echo $model->hasErrors("article")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'article',array('class'=>'span5','maxlength'=>100,'size' => 60)); ?></div>

	<div class='row-fluid control-group <?php echo $model->hasErrors("image")?"error":"" ?>'>
	     <?php if(!$model->isNewRecord && $model->image):?>
                <?php echo CHtml::image(Yii::app()->baseUrl.'/'.Yii::app()->getModule('yupe')->uploadPath . DIRECTORY_SEPARATOR . $this->module->uploadPath.DIRECTORY_SEPARATOR.$model->image, $model->name,array('width' => 300,'height' => 300));?>
            <?php endif;?>
            <?php echo  $form->fileFieldRow($model,'image',array('class'=>'span5','maxlength'=>300,'size' => 60)); ?>
	</div>

	<div class='row-fluid control-group <?php echo $model->hasErrors("is_special")?"error":"" ?>'><?php echo  $form->checkBoxRow($model,'is_special'); ?></div>
    
  	<div class='row-fluid control-group <?php echo $model->hasErrors("description")?"error":"" ?>'>
  		<?php echo $form->labelEx($model, 'description'); ?>
            <?php $this->widget(Yii::app()->getModule('yupe')->editor, array(
                                                'model' => $model,
                                                'attribute' => 'description',
                                                'options'   => array(
                                                    'toolbar' => 'main',
                                                    'imageUpload' => Yii::app()->baseUrl.'/index.php/yupe/backend/AjaxFileUpload/'
                                                ),
                                                'htmlOptions' => array('rows' => 20,'cols' => 6)
                                            ))?>
            <br /><?php echo $form->error($model, 'description'); ?>
  	</div>

	<div class='row-fluid control-group <?php echo $model->hasErrors("short_description")?"error":"" ?>'>
		<?php echo $form->labelEx($model, 'short_description'); ?>
            <?php $this->widget(Yii::app()->getModule('yupe')->editor, array(
                                                'model' => $model,
                                                'attribute' => 'short_description',
                                                'options'   => array(
                                                    'toolbar' => 'main',
                                                    'imageUpload' => Yii::app()->baseUrl.'/index.php/yupe/backend/AjaxFileUpload/'
                                                ),
                                                'htmlOptions' => array('rows' => 20,'cols' => 6)
                                            ))?>
            <br /><?php echo $form->error($model, 'description'); ?>
	</div>
	
	<div class='row-fluid control-group <?php echo $model->hasErrors("status")?"error":"" ?>'><?php echo  $form->dropDownList($model,'status',$model->getStatusList()); ?></div>

	
<?php $this->widget('bootstrap.widgets.BootButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'label'=>$model->isNewRecord ? Yii::t('yupe','Создать товар') : Yii::t('yupe','Сохранить товар'),
)); ?>
	

<?php $this->endWidget(); ?>
