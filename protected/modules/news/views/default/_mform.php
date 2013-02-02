<?php
    if ($model->hasErrors())
        echo $form->errorSummary($model);
?>
    <div class="row-fluid control-group  <?php echo $model-> hasErrors('title') ? 'error' : ''; ?>">
        <div class="span7 popover-help" data-content="<?php echo Yii::t('NewsModule.news', "Укажите краткое название данной страницы для отображения её в меню.<br/><br />Например:<pre>Контакты</pre>"); ?>" data-original-title="<?php echo $model->getAttributeLabel('title'); ?>">
            <?php echo $form->labelEx($model, 'title'); ?>
            <?php echo CHtml::textField('News[' . $model->lang . '][title]', $model->title, array('class' => 'span7','size' => 60, 'maxlength' => 150)); ?>
        </div>
        <div class="span5">
            <?php echo $form->error($model, 'title'); ?>
        </div>
    </div>

    <div class="row-fluid control-group <?php echo $model-> hasErrors('short_text') ? 'error' : ''; ?>">
        <div class="span12">
            <?php echo $form->labelEx($model, 'short_text'); ?>
            <?php $this->widget($this->module->editor, array(
                  'name'        => 'News[' . $model->lang . '][short_text]',
                  'value'       => $model->short_text,
                  'options'     => $this->module->editorOptions,
                  'htmlOptions' => array('id' => 'editor-' . $model->lang),
             )); ?>
            <br /><?php echo $form->error($model, 'News[' . $model->lang . '][short_text]'); ?>
        </div>
    </div>

     <div class="row-fluid control-group <?php echo $model-> hasErrors('full_text') ? 'error' : ''; ?>">
        <div class="span12">
            <?php echo $form->labelEx($model, 'full_text'); ?>
            <?php $this->widget($this->module->editor, array(
                  'name'        => 'News[' . $model->lang . '][full_text]',
                  'value'       => $model->full_text,
                  'options'     => $this->module->editorOptions,
                  'htmlOptions' => array('id' => 'editor-' . $model->lang . '-' . $model->id),
             )); ?>
            <br /><?php echo $form->error($model, 'news[' . $model->lang . '][full_text]'); ?>
        </div>
    </div>

    <div class="row-fluid control-group">
        <div class="span2 popover-help" data-content="<?php echo Yii::t('NewsModule.news', "<span class='label label-success'>Опубликовано</span> &ndash; Страницу видят все посетители сайта, режим по-умолчанию.<br /><br /><span class='label label-default'>Черновик</span> &ndash; Данная страница еще не окончена и не должна отображаться.<br /><br /><span class='label label-info'>На модерации</span> &ndash; Данная страница еще не проверена и не должна отображаться."); ?>" data-original-title="<?php echo $model->getAttributeLabel('status'); ?>">
            <?php echo $form->labelEx($model, 'status'); ?>
            <?php echo CHtml::dropDownList('News[' . $model->lang . '][status]', $model->status, $model->getStatusList()); ?>
        </div>
    </div>

    </br>

    <?php $collapse = $this->beginWidget('bootstrap.widgets.TbCollapse');?>
    <div class="accordion-group">
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                <?php echo Yii::t('BlogModule.blog','Данные для поисковой оптимизации');?>
            </a>
        </div>
        <div id="collapseOne" class="accordion-body collapse">
            <div class="accordion-inner">
                <div class="row-fluid control-group <?php echo $model->hasErrors('keywords') ? 'error' : ''; ?>">
                    <?php echo $form->labelEx($model, 'keywords'); ?>
                    <?php echo CHtml::textField('News[' . $model->lang . '][keywords]', $model->keywords, array('size' => 60, 'maxlength' => 150, 'class'=>'span7')); ?>
                </div>
                <div class="row-fluid control-group <?php echo $model->hasErrors('description') ? 'error' : ''; ?>">
                    <?php echo $form->labelEx($model, 'description'); ?>
                    <?php echo CHtml::textArea('News[' . $model->lang . '][description]', $model->description, array('rows' => 3, 'cols' => 98,'class' => 'span7')); ?>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endWidget();?>