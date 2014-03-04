<?php
$form = $this->beginWidget(
	'bootstrap.widgets.TbActiveForm', array(
	    'id'                     => 'user-tokens-form',
	    'enableAjaxValidation'   => false,
	    'enableClientValidation' => true,
	    'type'                   => 'vertical',
	    'htmlOptions'            => array('class' => 'well'),
	    'inlineErrors'           => true,
	)
); ?>
 
    <div class="alert alert-info">
        <?php echo Yii::t('UserModule.user', 'Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('UserModule.user', 'are required'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class="row-fluid">
    	<div class="span6">
    		<?php echo $form->dropDownListRow($model, 'user_id', $model->getUserList(), array('class' => 'span12', 'empty' => '---')); ?>
    	</div>

    	<div class="span6">
    		<?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('class' => 'span12')); ?>
    	</div>
    </div>

    <div class="row-fluid">
    	<div class="span6">
    		<?php echo $form->dropDownListRow($model, 'type', $model->getTypeList(), array('class' => 'span12', 'empty' => '---')); ?>
    	</div>

    	<div class="span6">
    		<div class="span8">
    			<?php echo $form->textFieldRow($model, 'token',  array('class' => 'span12')); ?>
    		</div>			
    	</div>
    </div>

    <div class="row-fluid">
    	<div class="span6">
	    	<?php echo $form->labelEx($model, 'created'); ?>
	    	<div class="input-prepend row-fluid">
	    		<span class="add-on"><i class="icon-calendar"></i></span>
		    	<?php $this->widget(
		    		'bootstrap.widgets.TbDateTimePicker', array(
						'model'       => $model,
						'attribute'   => 'created',
						'htmlOptions' => array(							
							'class' => 'span11',
							'value' => !empty($model->created)
										? $model->beautifyDate($model->created, 'yyyy-MM-dd HH:mm')
										: date('Y-m-d H:i')
						),
		    		)
		    	); ?>
		    </div>
    	</div>

    	<div class="span6">
    		<?php echo $form->labelEx($model, 'updated'); ?>
	    	<div class="input-prepend row-fluid">
	    		<span class="add-on"><i class="icon-calendar"></i></span>
		    	<?php $this->widget(
		    		'bootstrap.widgets.TbDateTimePicker', array(
						'model'       => $model,
						'attribute'   => 'updated',
						'htmlOptions' => array(							
							'class' => 'span11',
							'value' => !empty($model->updated)
										? $model->beautifyDate($model->updated, 'yyyy-MM-dd HH:mm')
										: date('Y-m-d H:i')
						),
		    		)
		    	); ?>
		    </div>
    	</div>
    </div>

	<div class="form-actions">
		<?php $this->widget(
			'bootstrap.widgets.TbButton', array(
		        'buttonType' => 'submit',
		        'type'       => 'primary',
		        'label'      => $model->isNewRecord ? Yii::t('UserModule.user', 'Create token and continue') : Yii::t('UserModule.user', 'Save token and continue'),
		    )
		); ?>
	    <?php $this->widget(
	    	'bootstrap.widgets.TbButton', array(
		        'buttonType'  => 'submit',
		        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
		        'label'       => $model->isNewRecord ? Yii::t('UserModule.user', 'Create token and close') : Yii::t('UserModule.user', 'Save token and close'),
		    )
		); ?>
	</div>

<?php $this->endWidget(); ?>