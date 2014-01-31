<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action'      => Yii::app()->createUrl($this->route),
    'method'      => 'get',
    'type'        => 'vertical',
    'htmlOptions' => array(
        'class' => 'well',
    ),
)); ?>

    <div class="row-fluid">
        <div class="span3">
            <?php echo $form->textFieldRow($model, 'name', array('maxlength' => 150, 'size' => 60)); ?>
        </div>
        <div class="span3">
            <?php echo $form->textFieldRow($model, 'email', array('size' => 60, 'maxlength' => 60)); ?>
        </div>
        <div class="span3">
            <?php echo $form->textFieldRow($model, 'phone', array('size' => 60, 'maxlength' => 60)); ?>
        </div>
        <div class="span3">
            <?php echo $form->textFieldRow($model, 'theme', array('size' => 60, 'maxlength' => 60)); ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span3">
            <?php echo $form->dropDownListRow(
                $model, 'type', $model->typeList, array(
                    'empty' => '---',
                )
            ); ?>
        </div>
        <div class="span3">
            <?php echo $form->dropDownListRow(
                $model, 'status', $model->statusList, array(
                    'empty' => '---',
                )
            ); ?>
        </div>
        <div class="span3">
            <?php echo $form->dropDownListRow(
                $model, 'category_id', Category::model()->getFormattedList((int)Yii::app()->getModule('feedback')->mainCategory), array(
                    'empty' => '---',
                )
            ); ?>
        </div>
        <div class="span3">
            <?php echo $form->datepickerRow(
                $model,
                'creation_date',
                array(                   
                    'options' => array(
                        'language'   => Yii::app()->language,
                        'format'     => 'yyyy-mm-dd',
                    ),                   
                )
            ); ?>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span4">
            <?php echo $form->textFieldRow($model, 'id', array('maxlength' => 10, 'size' => 60)); ?>
        </div>
    </div>
    <?php echo $form->checkBoxRow($model, 'is_faq', $model->isFaqList); ?>
    <div class='hide'>
        <?php $this->widget(
            'application.modules.yupe.widgets.editors.imperaviRedactor.ImperaviRedactorWidget', array(
                'model'       => $model,
                'attribute'   => 'answer',
            )
        ); ?>
    </div>

    <?php $this->widget(
        'bootstrap.widgets.TbButton', array(
            'type'        => 'primary',
            'encodeLabel' => false,
            'buttonType'  => 'submit',
            'label'       => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('FeedbackModule.feedback', 'Find messages '),
        )
    ); ?>

    <?php $this->widget(
        'bootstrap.widgets.TbButton', array(
            'type'        => 'danger',
            'encodeLabel' => false,
            'buttonType'  => 'reset',
            'label'       => Yii::t('FeedbackModule.feedback', 'Reset'),
        )
    ); ?>

<?php $this->endWidget(); ?>
