<?php
    if ($model->hasErrors())
        echo $form->errorSummary($model);
?>

    <div class="row-fluid control-group  <?php echo $model-> hasErrors('title') ? 'error' : ''; ?>">
        <div class="span7 popover-help" data-content="<?php echo Yii::t('news', "Укажите краткое название данной страницы для отображения её в меню.<br/><br />Например:<pre>Контакты</pre>"); ?>" data-original-title="<?php echo $model->getAttributeLabel('title'); ?>">
            <?php echo $form->labelEx($model, 'title'); ?>
            <?php echo CHtml::textField('News[' . $model->lang . '][title]', $model->title, array('size' => 60, 'maxlength' => 150)); ?>
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
                  'options'     => array(
                       'height'      => '400px;',
                       'toolbar'     => 'main',
                       'imageUpload' => Yii::app()->baseUrl . '/index.php/yupe/backend/AjaxFileUpload/',
                   ),
                  'htmlOptions' => array('style'=>'height: 400px;', 'rows' => 20, 'cols' => 6, 'id'=>'editor-' . $model->lang),
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
                  'options'     => array(
                       'height'      => '400px;',
                       'toolbar'     => 'main',
                       'imageUpload' => Yii::app()->baseUrl . '/index.php/yupe/backend/AjaxFileUpload/',
                   ),
                  'htmlOptions' => array('style'=>'height: 400px;','rows' => 20,'cols' => 6, 'id'=>'editor-' . $model->lang . '-' . $model->id),
             )); ?>
            <br /><?php echo $form->error($model, 'news[' . $model->lang . '][full_text]'); ?>
        </div>
    </div>

    <div class="row-fluid control-group <?php echo $model-> hasErrors('keywords') ? 'error' : ''; ?>">
        <div class="span7  popover-help" data-content="<?php echo Yii::t('news', "Ключевые слова необходимы для SEO-оптимизации страниц сайта. Выделите несколько основных смысловых слов из страницы и напишите их здесь через запятую. К примеру, если страница содержит контактную информацию, логично использовать такие ключевые слова: <pre>адрес, карта проезда, контакты, реквизиты</pre>  "); ?>" data-original-title="<?php echo $model->getAttributeLabel('keywords'); ?>">
            <?php echo $form->labelEx($model, 'keywords'); ?>
            <?php echo CHtml::textField('News[' . $model->lang . '][keywords]', $model->keywords, array('size' => 60, 'maxlength' => 150, 'class'=>'span7')); ?>
         </div>
        <div class="span5">
            <?php echo $form->error($model, 'keywords'); ?>
        </div>
    </div>

    <div class="row-fluid control-group <?php echo $model-> hasErrors('description')?'error':'' ?>">
        <div class="span7  popover-help" data-content="<?php echo Yii::t('news',"Краткое описание данной страницы, одно или два предложений. Обычно это самая главная мысль, к примеру: <pre>Контактная информация, реквизиты и карта проезда компании ОАО &laquo;Рога-унд-Копыта индастриз&raquo;</pre>Данный текст очень часто попадает в <a href='http://help.yandex.ru/webmaster/?id=1111310'>сниппет</a> поисковых систем."); ?>" data-original-title="<?php echo $model->getAttributeLabel('description'); ?>">
            <?php echo $form->labelEx($model, 'description'); ?>
            <?php echo CHtml::textArea('News[' . $model->lang . '][description]', $model->description, array('rows' => 3, 'cols' => 98)); ?>
        </div>
        <div class="span5">
            <?php echo $form->error($model, 'description'); ?>
        </div>
    </div>

    <div class="row-fluid control-group">
        <div class="span2 popover-help" data-content="<?php echo Yii::t('news', "<span class='label label-success'>Опубликовано</span> &ndash; Страницу видят все посетители сайта, режим по-умолчанию.<br /><br /><span class='label label-default'>Черновик</span> &ndash; Данная страница еще не окончена и не должна отображаться.<br /><br /><span class='label label-info'>На модерации</span> &ndash; Данная страница еще не проверена и не должна отображаться."); ?>" data-original-title="<?php echo $model->getAttributeLabel('status'); ?>">
            <?php echo $form->labelEx($model, 'status'); ?>
            <?php echo CHtml::dropDownList('News[' . $model->lang . '][status]', $model->status, $model->getStatusList()); ?>
        </div>
    </div>