    <?php $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
                                                         'id' => 'news-form',
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
        <div class="alert alert-info"><?php echo Yii::t('news', 'Поля, отмеченные * обязательны для заполнения')?></div>

        <?php echo $form->errorSummary($model); ?>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('date')?'error':'' ?>">
            <div class="span7 popover-help" data-content="<?=Yii::t('news',"Дата публикации новости, также используется для упорядочивания списка новостей.") ?>" data-original-title="<?php echo $model-> getAttributeLabel('date'); ?>" >
                <?php echo $form->labelEx($model, 'date'); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'date',
                'options' => array(
                    'dateFormat' => 'dd.mm.yy',
                ),
            ));
                ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'date'); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('title')?'error':'' ?>">
            <div class="span7 popover-help" data-content="<?=Yii::t('news',"Русское название, которое будет отображаться заголовком в списке и полной версии.<br /><br />Например:<br /><pre>Вышла новая 0.0.5 версия CMS ЮПИ!Встречайте и качайте!</pre>") ?>" data-original-title="<?php echo $model-> getAttributeLabel('title'); ?>" >
                <?php echo $form->labelEx($model, 'title'); ?>
                <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 150)); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'title'); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('alias')?'error':'' ?>">
            <div class="span7 popover-help" data-content="<?=Yii::t('news',"Краткое название новости латинскими буквами, используется для формирования адреса полной новости.<br /><br /> Например (выделено темным фоном): <pre>http://site.ru/news/<span class='label'>novost-dnya</span>/</pre> Если вы не знаете, для чего вам нужно это поле &ndash; не заполняйте его, заголовка новости будет достаточно.") ?>" data-original-title="<?php echo $model-> getAttributeLabel('url'); ?>" >
                <?php echo $form->labelEx($model, 'alias'); ?>
                <?php echo $form->textField($model, 'alias', array('size' => 60, 'maxlength' => 150, 'placeholder' => Yii::t('news', 'Оставьте пустым для автоматической генерации'))); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'alias'); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('short_text')?'error':'' ?>">
            <div class="span12">
                <?php echo $form->labelEx($model, 'short_text'); ?>
                <?php $this->widget($this->module->editor, array(
                'model' => $model,
                'attribute' => 'short_text',
                'options'   => array(
                    'toolbar' => 'main',
                    'imageUpload' => Yii::app()->baseUrl.'/index.php/yupe/backend/AjaxFileUpload/'
                ),
                'htmlOptions' => array('rows' => 20,'cols' => 6)
            ))?>
                <span class="help-block"><?=Yii::t('news',"Опишите основную мысль новости или напишие некий вводный текст (анонс), пары предложений обычно достаточно. Данный текст используется при выводе списка новостей, например, на главной странице.") ?></span>
                <?php echo $form->error($model, 'short_text'); ?>
            </div>
        </div>
        <div class="row-fluid control-group <?php echo $model-> hasErrors('full_text')?'error':'' ?>">
            <div class="span12">
                <?php echo $form->labelEx($model, 'short_text'); ?>
                <?php $this->widget($this->module->editor, array(
                'model' => $model,
                'attribute' => 'full_text',
                'options'   => array(
                    'toolbar' => 'main',
                    'imageUpload' => Yii::app()->baseUrl.'/index.php/yupe/backend/AjaxFileUpload/'
                ),
                'htmlOptions' => array('rows' => 20,'cols' => 6)
            ))?>

                <span class="help-block"><?=Yii::t('news',"Полный текст новости отображается при переходе по ссылке &laquo;Подробнее&raquo; или иногда при клике на заголовке новости.") ?></span>
                <?php echo $form->error($model, 'full_text'); ?>
            </div>
        </div>


        <div class="row-fluid control-group <?php echo $model-> hasErrors('keywords')?'error':'' ?>">
            <div class="span7 popover-help" data-content="<?=Yii::t('news',"Ключевые слова необходимы для SEO-оптимизации страниц сайта. Выделите несколько основных смысловых слов из новости и напишите их здесь через запятую. К примеру, если новость &ndash; о выходе новой версии Юпи, логично использовать такие ключевые слова: <pre>ЮПИ, новая версия, релиз, скачать</pre>  ") ?>" data-original-title="<?php echo $model-> getAttributeLabel('keywords'); ?>" >
                <?php echo $form->labelEx($model, 'keywords'); ?>
                <?php echo $form->textField($model, 'keywords', array('size' => 60, 'maxlength' => 150)); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'keywords'); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('description')?'error':'' ?>">
            <div class="span7 popover-help" data-content="<?=Yii::t('news',"Краткое описание данной новости, одно или два предложений. Обычно это самая главная мысль новости, к примеру: <pre>Вышла новая 0.4.3 версия CMS ЮПИ!Информация о нововведениях и изменениях.</pre>Данный текст очень часто попадает в <a href='http://help.yandex.ru/webmaster/?id=1111310'>сниппет</a> поисковых систем.") ?>" data-original-title="<?php echo $model-> getAttributeLabel('description'); ?>" >
                <?php echo $form->labelEx($model, 'description'); ?>
                <?php echo $form->textArea($model, 'description', array('rows' => 6, 'cols' => 86)); ?>
                <div class="alert alert-info"><?=Yii::t('news',"Более подробно вы можете прочитать про поисковую оптимизацию сайта в <a href='http://help.yandex.ru/webmaster/recomend.pdf'>этом документе</a>.");?></div>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'description'); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('is_protected')?'error':'' ?>">
            <div class="span7 popover-help" data-content="<?=Yii::t('news',"Если установлена данная галочка, новость будет отображаться только для авторизованных пользователей, гости, не вошедшие на сайт, не увидят ее.") ?>" data-original-title="<?php echo $model-> getAttributeLabel('is_protected'); ?>" >
                <?php echo $form->checkBoxRow($model, 'is_protected', $model->getProtectedStatusList()); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('status')?'error':'' ?>">
            <div class="span7  popover-help" data-content="<?=Yii::t('news',"<span class='label label-success'>Опубликовано</span> &ndash; Новость видят все посетители сайта, режим по-умолчанию.<br /><br /><span class='label label-default'>Черновик</span> &ndash; Данная новость еще не окончена и не должна отображаться.<br /><br /><span class='label label-info'>На модерации</span> &ndash; Данная новость еще не проверена и не должна отображаться.") ?>" data-original-title="<?php echo $model-> getAttributeLabel('status'); ?>" >
                <?php echo $form->labelEx($model, 'status'); ?>
                <?php echo $form->dropDownList($model, 'status', $model->getStatusList()); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'status'); ?>
            </div>
        </div>

        <?php $this->widget('bootstrap.widgets.BootButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' =>      $model->isNewRecord
                        ? Yii::t('news', 'Добавить новость')
                        : Yii::t('news', 'Сохранить изменения'))); ?>
    </fieldset>
    <?php $this->endWidget(); ?>

