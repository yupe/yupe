<div class="wide form">

<?php
    $form = $this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
    ));
?>

    <div class="row">
        <?php echo $form->label($model, 'id'); ?>
        <?php echo $form->textField($model, 'id', array('size'=>10, 'maxlength'=>10)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'blog_id'); ?>
        <?php
            echo $form->dropDownList($model, 'blog_id', 
                CHtml::listData(Blog::model()->findAll(), 'id', 'name'),
                array('empty'=>Yii::t('blog', 'выберите блог'))
            );
        ?>
    </div>    

    <div class="row">
        <?php echo $form->label($model, 'slug'); ?>
        <?php echo $form->textField($model, 'slug', array('size'=>60, 'maxlength'=>150)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'publish_date'); ?>
        <?php echo $form->textField($model, 'publish_date'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'title'); ?>
        <?php echo $form->textField($model, 'title', array('size'=>60, 'maxlength'=>150)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'quote'); ?>
        <?php echo $form->textField($model, 'quote', array('size'=>60, 'maxlength'=>300)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'content'); ?>
        <?php echo $form->textArea($model, 'content', array('rows'=>6, 'cols'=>50)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'link'); ?>
        <?php echo $form->textField($model, 'link', array('size'=>60, 'maxlength'=>150)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', $model->getStatusList()); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'comment_status'); ?>
        <?php echo $form->checkBox($model, 'comment_status'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'access_type'); ?>
        <?php echo $form->dropDownList($model, 'access_type', $model->getAccessTypeList()); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'keywords'); ?>
        <?php echo $form->textField($model, 'keywords', array('size'=>60, 'maxlength'=>150)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'description'); ?>
        <?php echo $form->textField($model, 'description', array('size'=>60, 'maxlength'=>150)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton(Yii::t('blog', 'Поиск')); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->