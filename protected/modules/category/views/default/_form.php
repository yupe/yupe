<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'category-form',
	'enableAjaxValidation'=>false,
	'type'=>'vertical',
        'htmlOptions' => array('class' => 'well form-vertical','enctype' => 'multipart/form-data')
)); ?>

<div class="alert alert-info"><?php echo Yii::t('yupe','Поля, отмеченные');?> <span class="required">*</span> <?php echo Yii::t('yupe','обязательны.');?></div>

	<?php echo  $form->errorSummary($model); ?>

	<div class='row-fluid control-group <?php echo $model->hasErrors("parent_id")?"error":"" ?>'>
            <?php echo  $form->dropDownList($model,'parent_id',CHtml::listData(Category::model()->findAll(),'id','name'),array('empty' => Yii::t('category','--нет--'))); ?>
        </div>

    <div class='row-fluid control-group <?php echo $model->hasErrors("name")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>150,'size' => 60)); ?></div>
    
    <div class='row-fluid control-group <?php echo $model->hasErrors("alias")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'alias',array('class'=>'span5','maxlength'=>100,'size' => 60)); ?></div>
	
	<div class='row-fluid control-group <?php echo $model->hasErrors("image")?"error":"" ?>'>
            <?php if(!$model->isNewRecord && $model->image):?>
                <?php echo CHtml::image(Yii::app()->baseUrl.'/'.Yii::app()->getModule('yupe')->uploadPath . DIRECTORY_SEPARATOR . $this->module->uploadPath.DIRECTORY_SEPARATOR.$model->image, $model->name,array('width' => 300,'height' => 300));?>
            <?php endif;?>
            <?php echo  $form->fileFieldRow($model,'image',array('class'=>'span5','maxlength'=>300,'size' => 60)); ?>
        </div>

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
            <br /><?php echo $form->error($model, 'short_description'); ?>
        </div>

	<div class='row-fluid control-group <?php echo $model->hasErrors("status")?"error":"" ?>'>
            <?php echo  $form->dropDownList($model,'status',$model->getStatusList()); ?>
        </div>


<?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'label'=>$model->isNewRecord ? Yii::t('yupe','Создать категорию') : Yii::t('yupe','Сохранить категорию'),
)); ?>


<?php $this->endWidget(); ?>
