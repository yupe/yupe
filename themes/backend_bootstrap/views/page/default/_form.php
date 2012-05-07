<?php $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
                                                         'id' => 'page-form',
                                                         'enableAjaxValidation' => false,
                                                         'htmlOptions'=> array( 'class' => 'well' ),
                                                    ));
    Yii::app()->clientScript->registerScript('fieldset', "
                $('document').ready(function ()
                { $('.popover-help').popover({ 'delay': 500, });
                });
            ");

?>
    <fieldset class="inline">
    <div class="alert alert-info"><?php echo Yii::t('page', 'Поля, отмеченные * обязательны для заполнения')?></div>

    <?php
        if ( $model-> hasErrors() )
            echo $form->errorSummary($model);
     ?>

        <div class="row-fluid control-group">
            <div class="span3">
                <?php echo $form->labelEx($model, 'parent_Id' ); ?>
                <?php echo $form->dropDownList($model, 'parent_Id', $pages); ?>
            </div>
            <div class="span2 popover-help" data-content="<?=Yii::t('page',"<span class='label label-success'>Опубликовано</span> &ndash; Страницу видят все посетители сайта, режим по-умолчанию.<br /><br /><span class='label label-default'>Черновик</span> &ndash; Данная страница еще не окончена и не должна отображаться.<br /><br /><span class='label label-info'>На модерации</span> &ndash; Данная страница еще не проверена и не должна отображаться.") ?>" data-original-title="<?php echo $model-> getAttributeLabel('status'); ?>" >
                <?php echo $form->labelEx($model, 'status' ); ?>
                <?php echo $form->dropDownList($model, 'status', $model->getStatusList()); ?>
            </div>
            <div class="span2 popover-help" data-content="<?=Yii::t('page',"Чем большее числовое значение вы укажете в этом поле, тем выше будет позиция данной страницы в меню.") ?>" data-original-title="<?php echo $model-> getAttributeLabel('menu_order'); ?>" >
                <?php echo $form->labelEx($model, 'menu_order' ); ?>
                <?php echo $form->textField($model, 'menu_order', array('size' => 10, 'maxlength' => 10)); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'menu_order'); ?>
            </div>
        </div>
        <div class="row-fluid control-group  <?php echo $model-> hasErrors('name')?'error':'' ?>">
            <div class="span7 popover-help" data-content="<?=Yii::t('page',"Укажите краткое название данной страницы для отображения её в меню.<br/><br />Например:<pre>Контакты</pre>") ?>" data-original-title="<?php echo $model-> getAttributeLabel('name'); ?>" >
                <?php echo $form->labelEx($model, 'name'); ?>
                <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 150,)); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'name'); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('title')?'error':'' ?>">
            <div class="span7 popover-help" data-content="<?=Yii::t('page',"Укажите полное название данной страницы для отображения в заголовке при полном просмотре.<br/><br />Например:<pre>Контактная информация и карта проезда.</pre>") ?>" data-original-title="<?php echo $model-> getAttributeLabel('title'); ?>" >
                <?php echo $form->labelEx($model, 'title'); ?>
                <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 150)); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'title'); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('slug')?'error':'' ?>">
            <div class="span7  popover-help" data-content="<?=Yii::t('page',"Краткое название страницы латинскими буквами, используется для формирования её адреса.<br /><br /> Например (выделено темным фоном): <pre>http://site.ru/page/<span class='label'>contacts</span>/</pre> Если вы не знаете, для чего вам нужно это поле &ndash; не заполняйте его, заголовка страницы будет достаточно.") ?>" data-original-title="<?php echo $model-> getAttributeLabel('slug'); ?>" >
                <?php echo $form->labelEx($model, 'slug'); ?>
                <?php echo $form->textField($model, 'slug', array('size' => 60, 'maxlength' => 150,'placeholder'=>  Yii::t('page', 'Оставьте пустым для автоматической генерации') )); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'slug'); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('body')?'error':'' ?>">
            <div class="span12">
                <?php echo $form->labelEx($model, 'body'); ?>
                <?php $this->widget($this->module->editor, array(
                                                      'model' => $model,
                                                      'attribute' => 'body',
                                                      'options'   => array(
                                                           'toolbar' => 'main',
                                                           'imageUpload' => Yii::app()->baseUrl.'/index.php/yupe/backend/AjaxFileUpload/'
                                                       ),
                                                      'htmlOptions' => array('rows' => 20,'cols' => 6)
                                                 ))?>
                <br /><?php echo $form->error($model, 'body'); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('keywords')?'error':'' ?>">
            <div class="span7  popover-help" data-content="<?=Yii::t('page',"Ключевые слова необходимы для SEO-оптимизации страниц сайта. Выделите несколько основных смысловых слов из страницы и напишите их здесь через запятую. К примеру, если страница содержит контактную информацию, логично использовать такие ключевые слова: <pre>адрес, карта проезда, контакты, реквизиты</pre>  ") ?>" data-original-title="<?php echo $model-> getAttributeLabel('keywords'); ?>" >
                <?php echo $form->labelEx($model, 'keywords'); ?>
                <?php echo $form->textField($model, 'keywords', array('size' => 60, 'maxlength' => 150,'class'=>'span7')); ?>
             </div>
            <div class="span5">
                <?php echo $form->error($model, 'keywords'); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('description')?'error':'' ?>">
            <div class="span7  popover-help" data-content="<?=Yii::t('page',"Краткое описание данной страницы, одно или два предложений. Обычно это самая главная мысль, к примеру: <pre>Контактная информация, реквизиты и карта проезда компании ОАО &laquo;Рога-унд-Копыта индастриз&raquo;</pre>Данный текст очень часто попадает в <a href='http://help.yandex.ru/webmaster/?id=1111310'>сниппет</a> поисковых систем.") ?>" data-original-title="<?php echo $model-> getAttributeLabel('description'); ?>" >
                <?php echo $form->labelEx($model, 'description'); ?>
                <?php echo $form->textArea($model, 'description', array('rows' => 3, 'cols' => 98)); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'description'); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('is_protected')?'error':'' ?>">
            <div class="span7">
                <label for="Page_is_protected" class="checkbox">
                    <?php echo $form->checkBox($model, 'is_protected'); ?>
                    <?php echo $model-> getAttributeLabel('is_protected'); ?>
                </label>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'is_protected'); ?>
            </div>
        </div>

<br />
        <?php echo CHtml::submitButton($model->isNewRecord
                                           ? Yii::t('page', 'Добавить страницу и продолжить редактирование')
                                           : Yii::t('page', 'Сохранить и продолжить редактирование'), array(
                                            'class' => 'btn btn-primary',
                                           )); ?>
        <?php echo CHtml::submitButton($model->isNewRecord
                                           ? Yii::t('page', 'Добавить и закрыть')
                                           : Yii::t('page', 'Сохранить и закрыть'), array('name' => 'saveAndClose', 'id' => 'saveAndClose', 'class' => 'btn btn-info')); ?>
    </fieldset>
    <?php $this->endWidget(); ?>
