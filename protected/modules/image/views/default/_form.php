<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'image-form',
    'enableAjaxValidation'=>false,
    'type'=>'vertical',
        'htmlOptions' => array('class' => 'well form-vertical','enctype' => 'multipart/form-data')
)); ?>

<div class="alert alert-info"><?php echo Yii::t('yupe','Поля, отмеченные');?> <span class="required">*</span> <?php echo Yii::t('yupe','обязательны.');?></div>

    <?php echo  $form->errorSummary($model); ?>

    <div class='row-fluid control-group <?php echo $model->hasErrors("category_id")?"error":"" ?>'>
        <?php echo  $form->dropDownListRow($model,'category_id',CHtml::listData($this->module->getCategoryList(), 'id', 'name'), array( 'empty' => Yii::t('news', '--выберите--') )); ?>
    </div>

    <div class='row-fluid control-group <?php echo $model->hasErrors("name")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>300,'size' => 60)); ?></div>

    <div class='row-fluid control-group <?php echo $model->hasErrors("file")?"error":"" ?>'>
        <?php if($model->isNewRecord):?>
            <?php echo  $form->fileFieldRow($model,'file',array('class'=>'span5','maxlength'=>500,'size' => 60)); ?>
        <?php else:?>
            <?php echo CHtml::image($model->file,$model->alt);?>
        <?php endif;?>
    </div>

    <div class='row-fluid control-group <?php echo $model->hasErrors("alt")?"error":"" ?>'><?php echo  $form->textFieldRow($model,'alt',array('class'=>'span5','maxlength'=>150,'size' => 60)); ?></div>

    <div class='row-fluid control-group <?php echo $model->hasErrors("type")?"error":"" ?>'><?php echo  $form->dropDownListRow($model,'type',$model->getTypeList()); ?></div>    

    <div class='row-fluid control-group <?php echo $model->hasErrors("description")?"error":"" ?>'>
        <?php
          $this->widget($this->yupe->editor, array(
                'model'     => $model,
                'attribute' => 'description',
                'options'   => array(
                    'toolbar'     => 'main',
                    'imageUpload' => Yii::app()->baseUrl . '/index.php/yupe/backend/AjaxFileUpload/'
                ),
                'htmlOptions' => array( 'rows' => 20, 'cols' => 6 )
            ));
        ?>
    </div>

    <div class='row-fluid control-group <?php echo $model->hasErrors("status")?"error":"" ?>'><?php echo  $form->dropDownListRow($model,'status', $model->getStatusList()); ?></div>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'=>'submit',
    'type'=>'primary',
    'label'=>$model->isNewRecord ? Yii::t('yupe','Добавить изображение') : Yii::t('yupe','Сохранить изображение'),
)); ?>

<?php $this->endWidget(); ?>
