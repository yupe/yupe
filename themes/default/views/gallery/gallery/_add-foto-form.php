<div class="form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'add-image-form',
        'enableClientValidation' => true,
        'htmlOptions' => array('enctype' => 'multipart/form-data','class' => 'well')
    )); ?>


    <?php echo $form->errorSummary($model); ?>

    <div class='row-fluid control-group <?php echo $model->hasErrors('file') ? 'error' : ''; ?>'>
        <?php echo $form->fileFieldRow($model, 'file', array('class' => 'span6', 'required' => true)); ?>
    </div>

    <div class='row-fluid control-group <?php echo $model->hasErrors('name') ? 'error' : ''; ?>'>
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span6', 'required' => true)); ?>
    </div>

    <div class='row-fluid control-group <?php echo $model->hasErrors('description') ? 'error' : ''; ?>'>
        <?php echo $form->textAreaRow($model, 'description', array('class' => 'span12', 'required' => true,'rows' => 7, 'cols' => 30)); ?>
    </div>

    <div class='row-fluid control-group <?php echo $model->hasErrors('alt') ? 'error' : ''; ?>'>
        <?php echo $form->textFieldRow($model, 'alt', array('class' => 'span6', 'required' => true)); ?>
    </div>

    <?php if ($model->file !== null) : ?>
        <div class="row-fluid">
            <?php  echo CHtml::image($model->getUrl(190), $model->alt); ?>
        </div>
    <?php endif; ?>

    <div class="row-fluid  control-group">
        <?php
        $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'icon' => 'picture',
                'label' => Yii::t('comment', 'Добавить фото'),
            )
        ); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->