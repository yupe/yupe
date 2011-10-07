<div class="wide form">

    <?php $form = $this->beginWidget('CActiveForm', array(
                                                         'action' => Yii::app()->createUrl($this->route),
                                                         'method' => 'get',
                                                    )); ?>

    <div class="row">
        <?php echo $form->label($model, 'id'); ?>
        <?php echo $form->textField($model, 'id', array('size' => 10, 'maxlength' => 10)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 50, 'maxlength' => 150)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'description'); ?>
        <?php echo $form->textArea($model, 'description', array('cols' => 65, 'rows' => 7)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'start_add_image'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                                   'model' => $model,
                                                                   'attribute' => 'start_add_image',
                                                                   'options' => array(
                                                                       'dateFormat' => 'yy-mm-dd',
                                                                   ),
                                                              )); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'stop_add_image'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                                   'model' => $model,
                                                                   'attribute' => 'stop_add_image',
                                                                   'options' => array(
                                                                       'dateFormat' => 'yy-mm-dd',
                                                                   ),
                                                              )); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'start_vote'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                                   'model' => $model,
                                                                   'attribute' => 'start_vote',
                                                                   'options' => array(
                                                                       'dateFormat' => 'yy-mm-dd',
                                                                   ),
                                                              )); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'stop_vote'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                                                   'model' => $model,
                                                                   'attribute' => 'stop_vote',
                                                                   'options' => array(
                                                                       'dateFormat' => 'yy-mm-dd',
                                                                   ),
                                                              )); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', $model->getStatusList()); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('contest', 'Поиск')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->