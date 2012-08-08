<?php $this->pageTitle = Yii::t('page', 'Редактирование страницы'); ?>

<?php
$this->breadcrumbs = array(
    $this->getModule('page')->getCategory() => array(''),
    Yii::t('page', 'Страницы') => array('admin'),
    $model->title => array('view', 'id' => $model->id),
    Yii::t('page', 'Изменение'),
);

$this->menu = array(
    array('icon' => 'list-alt', 'label' => Yii::t('page', 'Управление страницами'), 'url' => array('admin')),
    array('icon' => 'file', 'label' => Yii::t('page', 'Добавить страницу'), 'url' => array('/page/default/create')),
    array('icon' => 'pencil white', 'encodeLabel'=> false, 'label' => Yii::t('page', 'Редактирование страницы')."<br /><span class='label' style='font-size: 80%;'>".mb_substr($model-> name,0,32)."</span>", 'url' => array('/page/default/update','id'=> $model-> id)),
);
?>

<div class="page-header">
  <h1><?php echo Yii::t('page', 'Редактирование страницы')?>
  <br /><small style="margin-left:-10px;">&laquo;<?php echo $model->title; ?>&raquo;</small>
  </h1>
</div>
<?php
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id' => 'page-form',
    'enableAjaxValidation' => false,
    //'htmlOptions'=> array( 'class' => 'well' ),
));
echo CHtml::openTag("fieldset", array("class"=>"inline"));
?>
    <div class="alert alert-info"><?php echo Yii::t('page', 'Поля, отмеченные * обязательны для заполнения')?></div>
    <div class="row-fluid control-group">
        <div class="span3">
            <?php echo $form->labelEx($model, 'category_id' ); ?>
            <?php echo $form->dropDownList($model, 'category_id', CHtml::listData($this->module->getCategoryList(), 'id', 'name'), array( 'empty' => Yii::t('news', '--выберите--'))); ?>
        </div>
        <div class="span3">
            <?php echo $form->labelEx($model, 'parent_Id' ); ?>
            <?php echo $form->dropDownList($model, 'parent_Id', $pages); ?>
        </div>
    </div>
    <div class="row-fluid control-group">
        <div class="span2 popover-help" data-content="<?php echo Yii::t('page', "<span class='label label-success'>Опубликовано</span> &ndash; Страницу видят все посетители сайта, режим по-умолчанию.<br /><br /><span class='label label-default'>Черновик</span> &ndash; Данная страница еще не окончена и не должна отображаться.<br /><br /><span class='label label-info'>На модерации</span> &ndash; Данная страница еще не проверена и не должна отображаться."); ?>" data-original-title="<?php echo $model->getAttributeLabel('status'); ?>" >
            <?php echo $form->labelEx($model, 'status' ); ?>
            <?php echo $form->dropDownList($model, 'status', $model->getStatusList()); ?>
        </div>
        <div class="span2 popover-help" data-content="<?php echo Yii::t('page', "Чем большее числовое значение вы укажете в этом поле, тем выше будет позиция данной страницы в меню."); ?>" data-original-title="<?php echo $model->getAttributeLabel('menu_order'); ?>" >
            <?php echo $form->labelEx($model, 'menu_order' ); ?>
            <?php echo $form->textField($model, 'menu_order', array('size' => 10, 'maxlength' => 10)); ?>
        </div>
        <div class="span5">
            <?php echo $form->error($model, 'menu_order'); ?>
        </div>
    </div>
    <div class="row-fluid control-group <?php echo $model-> hasErrors('slug') ? 'error' : '' ?>">
        <div class="span7  popover-help" data-content="<?php echo Yii::t('page', "Краткое название страницы латинскими буквами, используется для формирования её адреса.<br /><br /> Например (выделено темным фоном): <pre>http://site.ru/page/<span class='label'>contacts</span>/</pre> Если вы не знаете, для чего вам нужно это поле &ndash; не заполняйте его, заголовка страницы будет достаточно."); ?>" data-original-title="<?php echo $model->getAttributeLabel('slug'); ?>" >
            <?php echo $form->labelEx($model, 'slug'); ?>
            <?php echo $form->textField($model, 'slug', array('size' => 60, 'maxlength' => 150, 'placeholder' => Yii::t('page', 'Оставьте пустым для автоматической генерации'))); ?>
        </div>
        <div class="span5">
            <?php echo $form->error($model, 'slug'); ?>
        </div>
    </div>

    <div class="row-fluid control-group <?php echo $model-> hasErrors('is_protected') ? 'error' : '' ?>">
        <div class="span7  popover-help" data-content="<?php echo Yii::t('page', "Страница будет видна только авторизованным пользователям"); ?>" data-original-title="<?php echo $model->getAttributeLabel('is_protected'); ?>" >
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
        'type' => 'tabs', // '', 'tabs', 'pills' (or 'list')
        'stacked' => false, // whether this is a stacked menu
        'items' => $items ,
        'htmlOptions' => array('style' => 'margin-bottom:0;'),
    ));
    Yii::app()->clientScript->registerScript('fieldset', "
        $('document').ready(function () {
            $('.popover-help').popover({ 'delay': 500, });
        });
    ");

    echo CHtml::openTag("div", array(
        "class" => "tab-content",
        'style' => 'background-color: whiteSmoke; padding: 5px; border-bottom: 1px solid #DDD; border-left: 1px solid #DDD; border-right: 1px solid #DDD;'
    ));
    foreach ( $langs as $l )
    {
        echo CHtml::openTag("div", array("class"=>"tab-pane ".($l == $model->lang ? "active" : ""), "id" => "tab-".$l));
        echo $this->renderPartial('_mform', array('model' => $models[$l], 'pages' => $pages, 'form' => $form ));
        echo CHtml::closeTag("div");
    }
    echo CHtml::closeTag("div");


    echo CHtml::closeTag("fieldset");
    echo "<br />";
    echo CHtml::submitButton($model->isNewRecord
        ? Yii::t('page', 'Добавить страницу и продолжить редактирование')
        : Yii::t('page', 'Сохранить и продолжить редактирование'), array('class' => 'btn btn-primary')
    );
    echo "&nbsp;";
    echo CHtml::submitButton($model->isNewRecord
        ? Yii::t('page', 'Добавить и закрыть')
        : Yii::t('page', 'Сохранить и закрыть'), array('name' => 'saveAndClose', 'id' => 'saveAndClose', 'class' => 'btn btn-info')
    );

    $this->endWidget();

?>