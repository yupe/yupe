<div class="wide form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>

    <div class="row">
        <?php echo $form->label($model, 'id'); ?>
        <?php
        echo $form->textField($model, 'id', array(
            'size' => 10,
            'maxlength' => 10,
        ));
        ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'name'); ?>
        <?php
        echo $form->textField($model, 'name', array(
            'size' => 60,
            'maxlength' => 300,
        ));
        ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'code'); ?>
        <?php
        echo $form->textField($model, 'code', array(
            'size' => 60,
            'maxlength' => 100,
        ));
        ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'description'); ?>
        <?php
        echo $form->textField($model, 'description', array(
            'size' => 60,
            'maxlength' => 300,
        ));
        ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', $model->getStatusList()); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('menu', 'Поиск')); ?>
    </div>

    <?php $this->endWidget(); ?>
</div><!-- search-form -->