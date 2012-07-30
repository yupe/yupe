<?php $this->pageTitle = Yii::t('news', 'Редактирование новости'); ?>

<?php
$this->breadcrumbs = array(
    $this->getModule('news')->getCategory() => array(''),
    Yii::t('news', 'Новости') => array('admin'),
    $model->title => array('view', 'id' => $model->id),
    Yii::t('news', 'Изменение'),
);

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('news', 'Управление новостями'), 'url' => array('admin')),
    array('icon' => 'file', 'label' => Yii::t('news', 'Добавить новость'), 'url' => array('/news/default/create')),
    array('icon' => 'pencil white', 'encodeLabel'=> false, 'label' => Yii::t('news', 'Редактирование новости')."<br /><span class='label' style='font-size: 80%;'>".mb_substr($model->title,0,32)."</span>", 'url' => array('/news/default/update','id'=> $model-> id)),
);
?>

<div class="news-header">
  <h1><?php echo Yii::t('news', 'Редактирование новости')?>
  <br /><small style="margin-left:-10px;">&laquo;<?php echo $model->title; ?>&raquo;</small>
  </h1>
</div>
<?php
    $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
        'id' => 'news-form',
        'enableAjaxValidation' => false,
    ));
    echo CHtml::openTag("fieldset", array("class"=>"inline"));
?>
        <div class="alert alert-info"><?php echo Yii::t('news', 'Поля, отмеченные * обязательны для заполнения')?></div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('alias')?'error':'' ?>">
            <div class="span7  popover-help" data-content="<?=Yii::t('news',"Краткое название страницы латинскими буквами, используется для формирования её адреса.<br /><br /> Например (выделено темным фоном): <pre>http://site.ru/news/<span class='label'>contacts</span>/</pre> Если вы не знаете, для чего вам нужно это поле &ndash; не заполняйте его, заголовка страницы будет достаточно.") ?>" data-original-title="<?php echo $model-> getAttributeLabel('alias'); ?>" >
                <?php echo $form->labelEx($model, 'alias'); ?>
                <?php echo $form->textField($model, 'alias', array('size' => 60, 'maxlength' => 150,'placeholder'=>  Yii::t('news', 'Оставьте пустым для автоматической генерации') )); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'alias'); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('date')?'error':'' ?>">
            <div class="span7 popover-help" data-content="<?php echo Yii::t('news',"Дата публикации новости, также используется для упорядочивания списка новостей.") ?>" data-original-title="<?php echo $model-> getAttributeLabel('date'); ; ?>" >
                <?php echo $form->labelEx($model, 'date'); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'date',
                'language' => Yii::app()->language,
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

        <div class="row-fluid control-group <?php echo $model-> hasErrors('is_protected')?'error':'' ?>">
            <div class="span7  popover-help" data-content="<?=Yii::t('news',"Страница будет видна только авторизованным пользователям") ?>" data-original-title="<?php echo $model-> getAttributeLabel('is_protected'); ?>" >
                <?php echo $form->labelEx($model, 'is_protected'); ?>
                <?php echo $form->checkBox($model, 'is_protected'); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'slug'); ?>
            </div>
        </div>

<?php
    $items = array();
    foreach ( $langs as $l )
        $items[]=array('label'=>"[".$l."] ".mb_convert_case(Yii::app()->locale-> getLocaleDisplayName($l), MB_CASE_TITLE, 'UTF-8'), 'url'=>'#tab-'.$l, 'linkOptions'=> array("data-toggle"=>"tab"), 'active'=>$l==$model->lang );

    $this->widget('bootstrap.widgets.BootMenu', array(
    'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'=>false, // whether this is a stacked menu
    'items'=> $items ,
    'htmlOptions'=> array('style'=>'margin-bottom:0;')
));
    Yii::app()->clientScript->registerScript('fieldset', "
                $('document').ready(function ()
                { $('.popover-help').popover({ 'delay': 500, });
                });
            ");


    echo CHtml::openTag("div",array("class"=>"tab-content",'style'=>'background-color: whiteSmoke; padding: 5px; border-bottom: 1px solid #DDD; border-left: 1px solid #DDD; border-right: 1px solid #DDD;'));
    foreach ( $langs as $l )
    {
        echo CHtml::openTag("div",array("class"=>"tab-pane ".($l==$model->lang?"active":""), "id"=>"tab-".$l));
        echo $this->renderPartial('_mform', array('model' => $models[$l], 'form' => $form ));
        echo CHtml::closeTag("div");
    }
    echo CHtml::closeTag("div");


    echo CHtml::closeTag("fieldset");
    echo "<br />";
    echo CHtml::submitButton($model->isNewRecord
        ? Yii::t('news', 'Добавить новость и продолжить редактирование')
        : Yii::t('news', 'Сохранить и продолжить редактирование'), array(
        'class' => 'btn btn-primary',
    ));
    echo "&nbsp;";
    echo CHtml::submitButton($model->isNewRecord
        ? Yii::t('news', 'Добавить и закрыть')
        : Yii::t('news', 'Сохранить и закрыть'), array('name' => 'saveAndClose', 'id' => 'saveAndClose', 'class' => 'btn btn-info'));

$this->endWidget();

?>



