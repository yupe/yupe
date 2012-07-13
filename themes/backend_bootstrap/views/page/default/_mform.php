
    <?php
        if ( $model-> hasErrors() )
            echo $form->errorSummary($model);
     ?>

        <div class="row-fluid control-group  <?php echo $model-> hasErrors('name')?'error':'' ?>">
            <div class="span7 popover-help" data-content="<?=Yii::t('page',"Укажите краткое название данной страницы для отображения её в меню.<br/><br />Например:<pre>Контакты</pre>") ?>" data-original-title="<?php echo $model-> getAttributeLabel('name'); ?>" >
                <?php echo $form->labelEx($model, 'name'); ?>
                <?php echo CHtml::textField('Page['.$model->lang.'][name]', $model->name ,array('size' => 60, 'maxlength' => 150,)); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'name'); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('title')?'error':'' ?>">
            <div class="span7 popover-help" data-content="<?=Yii::t('page',"Укажите полное название данной страницы для отображения в заголовке при полном просмотре.<br/><br />Например:<pre>Контактная информация и карта проезда.</pre>") ?>" data-original-title="<?php echo $model-> getAttributeLabel('title'); ?>" >
                <?php echo $form->labelEx($model, 'title'); ?>
                <?php echo CHtml::textField( 'Page['.$model->lang.'][title]',$model->title, array('size' => 60, 'maxlength' => 150)); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'title'); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('body')?'error':'' ?>">
            <div class="span12">
                <?php echo $form->labelEx($model, 'body'); ?>
                <?php $this->widget($this->module->editor, array(
                                                  //    'model' => $model,
                                                      //'attribute' => 'body',
                                                      'name' => 'Page['.$model->lang.'][body]',
                                                      'value' => $model->body,
                                                      'options'   => array(
                                                           'toolbar' => 'main',
                                                           'imageUpload' => Yii::app()->baseUrl.'/index.php/yupe/backend/AjaxFileUpload/'
                                                       ),
                                                      'htmlOptions' => array('rows' => 20,'cols' => 6, 'id'=>'editor-'.$model->lang)
                                                 ))?>
                <br /><?php echo $form->error($model, 'Page['.$model->lang.'][body]'); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('keywords')?'error':'' ?>">
            <div class="span7  popover-help" data-content="<?=Yii::t('page',"Ключевые слова необходимы для SEO-оптимизации страниц сайта. Выделите несколько основных смысловых слов из страницы и напишите их здесь через запятую. К примеру, если страница содержит контактную информацию, логично использовать такие ключевые слова: <pre>адрес, карта проезда, контакты, реквизиты</pre>  ") ?>" data-original-title="<?php echo $model-> getAttributeLabel('keywords'); ?>" >
                <?php echo $form->labelEx($model, 'keywords'); ?>
                <?php echo CHtml::textField('Page['.$model->lang.'][keywords]', $model->keywords ,array('size' => 60, 'maxlength' => 150,'class'=>'span7')); ?>
             </div>
            <div class="span5">
                <?php echo $form->error($model, 'keywords'); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('description')?'error':'' ?>">
            <div class="span7  popover-help" data-content="<?=Yii::t('page',"Краткое описание данной страницы, одно или два предложений. Обычно это самая главная мысль, к примеру: <pre>Контактная информация, реквизиты и карта проезда компании ОАО &laquo;Рога-унд-Копыта индастриз&raquo;</pre>Данный текст очень часто попадает в <a href='http://help.yandex.ru/webmaster/?id=1111310'>сниппет</a> поисковых систем.") ?>" data-original-title="<?php echo $model-> getAttributeLabel('description'); ?>" >
                <?php echo $form->labelEx($model, 'description'); ?>
                <?php echo CHtml::textArea('Page['.$model->lang.'][description]',$model->description ,array('rows' => 3, 'cols' => 98)); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'description'); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('is_protected')?'error':'' ?>">
            <div class="span7">
                <label for="Page_is_protected" class="checkbox">
                    <?php echo CHtml::checkBox('Page['.$model->lang.'][is_protected]', $model->is_protected); ?>
                    <?php echo $model-> getAttributeLabel('is_protected'); ?>
                </label>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'is_protected'); ?>
            </div>
        </div>