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
        <?php echo $form->label($model, 'title'); ?>
        <?php
        echo $form->textField($model, 'title', array(
            'size' => 60,
            'maxlength' => 300,
        ));
        ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'href'); ?>
        <?php
        echo $form->textField($model, 'href', array(
            'size' => 60,
            'maxlength' => 300,
        ));
        ?>
        <?php echo $form->error($model, 'href'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'menu_id'); ?>
        <?php echo $form->dropDownList($model, 'menu_id', CHtml::listData(Menu::model()->findAll(), 'id', 'name'), array('empty' => Yii::t('menu', 'выберите меню'))); ?>
        <?php echo $form->error($model, 'menu_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'parent_id'); ?>
        <?php echo $form->dropDownList($model, 'parent_id', $model->parentList); ?>
        <?php echo $form->error($model, 'parent_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'type'); ?>
        <?php
        echo $form->textField($model, 'type', array(
            'size' => 60,
            'maxlength' => 300,
        ));
        ?>
        <?php echo $form->error($model, 'type'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'sort'); ?>
        <?php
        echo $form->textField($model, 'sort', array(
            'size' => 60,
            'maxlength' => 300,
        ));
        ?>
        <?php echo $form->error($model, 'sort'); ?>
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