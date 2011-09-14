<?php $this->pageTitle = Yii::t('feedback','Сообщения с сайта');?>

<?php
$this->breadcrumbs=array(
	Yii::t('feedback','Сообщения с сайта') => array('admin'),
	$model->theme,
);

$this->menu=array(
	array('label'=>Yii::t('feedback','Управление сообщениями'), 'url'=>array('admin')),
	array('label'=>Yii::t('feedback','Добавить сообщение'), 'url'=>array('create')),
	array('label'=>Yii::t('feedback','Список сообщений'), 'url'=>array('index')),	
	array('label'=>Yii::t('feedback','Изменить данное сообщение'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('feedback','Удалить данное сообщение'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Подтверждаете удаление сообщения ?')),	
	array('label'=>Yii::t('feedback','Ответить на сообщение'), 'url'=>array('answer', 'id'=>$model->id)),
);
?>

<h1>Ответ на сообщение #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(		
		'creationDate',		
		'name',
		'email',
		'theme',
		'text',
		 array(
			'name'  => 'type',
			'value' => $model->getType()
		 ),
		 array(
			'name'  => 'status',
			'value' => $model->getStatus()
		 ),		
	),
)); ?>


<br/><br/>

<div class="form">

	<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'feed-back-form-answer',
		'action' => array('/feedback/default/answer/','id' => $model->id)	
	)); ?>


    <p class="note"><?php echo Yii::t('page','Поля, отмеченные * обязательны для заполнения')?></p>

	<?php echo $form->errorSummary($answerForm); ?>	    
    
    <div class="row">
		<?php echo $form->labelEx($answerForm,'answer'); ?>
		<?php $this->widget('application.widgets.EMarkItUp.EMarkitupWidget', array(    
				'model' => $answerForm,
				'attribute' => 'answer',
				'htmlOptions' => array('rows' => 6,'cols' => 6)
        ))?>
		<?php echo $form->error($answerForm,'answer'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($answerForm,'isFaq'); ?>
		<?php echo $form->checkBox($answerForm,'isFaq'); ?>
		<?php echo $form->error($answerForm,'isFaq'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('feedback','Отправить ответ')); ?>
	</div>

    <?php $this->endWidget(); ?>

</div><!-- form -->