
    <?php
        if ( $model-> hasErrors() )
            echo $form->errorSummary($model);
     ?>

        <div class="row-fluid control-group  <?php echo $model-> hasErrors('name')?'error':'' ?>">
            <div class="span7 popover-help" data-original-title="<?php echo $model-> getAttributeLabel('name'); ?>" >
                <?php echo $form->labelEx($model, 'name'); ?>
                <?php echo CHtml::textField('Category['.$model->lang.'][name]', $model->name ,array('size' => 60, 'maxlength' => 150,)); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'name'); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('short_description')?'error':'' ?>">
            <div class="span12">
                <?php echo $form->labelEx($model, 'short_description'); ?>
                <?php $this->widget($this->yupe->editor, array(
                      'name' => 'Category['.$model->lang.'][short_description]',
                      'value' => $model->short_description,
                      'options'   => array(
                           'height'=> '400px;',
                           'toolbar' => 'main',
                           'imageUpload' => Yii::app()->baseUrl.'/index.php/yupe/backend/AjaxFileUpload/',
                       ),
                      'htmlOptions' => array('style'=>'height: 400px;','rows' => 20,'cols' => 6, 'id'=>'editor-short-'.$model->lang)
                 )); ?>
                <br /><?php echo $form->error($model, 'Category['.$model->lang.'][short_description]'); ?>
            </div>
        </div>         

        <div class="row-fluid control-group <?php echo $model-> hasErrors('description')?'error':'' ?>">
            <div class="span12">
                <?php echo $form->labelEx($model, 'description'); ?>
                <?php $this->widget($this->yupe->editor, array(
                      'name' => 'Category['.$model->lang.'][description]',
                      'value' => $model->description,
                      'options'   => array(
                           'height'=> '400px;',
                           'toolbar' => 'main',
                           'imageUpload' => Yii::app()->baseUrl.'/index.php/yupe/backend/AjaxFileUpload/',
                       ),
                      'htmlOptions' => array('style'=>'height: 400px;','rows' => 20,'cols' => 6, 'id'=>'editor-'.$model->lang)
                 )); ?>
                <br /><?php echo $form->error($model, 'Category['.$model->lang.'][description]'); ?>
            </div>
        </div>  

        <div class="row-fluid control-group">
            <div class="span2 popover-help" data-content="<?php echo Yii::t('category',"<span class='label label-success'>Опубликовано</span> &ndash; Страницу видят все посетители сайта, режим по-умолчанию.<br /><br /><span class='label label-default'>Черновик</span> &ndash; Данная страница еще не окончена и не должна отображаться.<br /><br /><span class='label label-info'>На модерации</span> &ndash; Данная страница еще не проверена и не должна отображаться.") ?>" data-original-title="<?php echo $model-> getAttributeLabel('status'); ?>" >
                <?php echo $form->labelEx($model, 'status' ); ?>
                <?php echo CHtml::dropDownList('Category['.$model->lang.'][status]', $model->status, $model->getStatusList()); ?>
            </div>
        </div>

