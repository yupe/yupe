<?php $this->pageTitle = Yii::t('category', 'Редактирование категории'); ?>

<?php
$this->breadcrumbs = array(
    $this->getModule('category')->getCategory() => array( '' ),
    Yii::t('category', 'Новости') => array( 'admin' ),
    $model->name => array( 'view', 'id' => $model->id ),
    Yii::t('category', 'Изменение'),
);

$this->menu = array(
    array( 'icon' => 'list-alt', 'label' => Yii::t('category', 'Управление категориями'), 'url'   => array( 'index' ) ),
    array( 'icon' => 'file', 'label' => Yii::t('category', 'Добавить категорию'), 'url'   => array( 'create' ) ),
    array( 'icon' => 'pencil white', 'encodeLabel' => false, 'label' => Yii::t('category', 'Редактирование категории "') . mb_substr($model->name, 0, 32) . '"', 'url' => array( '/category/default/update', 'alias' => $model->alias ) ),
);
?>

<div class="news-header">
    <h1><?php echo Yii::t('category', 'Редактирование категории'); ?>
        <br /><small style="margin-left:-10px;">&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>
<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'category-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
echo CHtml::openTag("fieldset", array( "class" => "inline" ));
?>
<div class="alert alert-info"><?php echo Yii::t('category', 'Поля, отмеченные * обязательны для заполнения') ?></div>

<div class="row-fluid control-group <?php echo $model->hasErrors('parent_id') ? 'error' : '' ?>">
    <div class="span7  popover-help" data-original-title="<?php echo $model->getAttributeLabel('parent_id'); ?>" >
        <?php echo $form->labelEx($model, 'parent_id'); ?>
        <?php echo $form->dropDownList($model, 'parent_id', CHtml::listData(Category::model()->findAll(), 'id', 'name'), array( 'empty' => Yii::t('news', '--выберите--') )); ?>
    </div>
    <div class="span5">
        <?php echo $form->error($model, 'parent_id'); ?>
    </div>
</div>

<div class="row-fluid control-group <?php echo $model->hasErrors('alias') ? 'error' : '' ?>">
    <div class="span7  popover-help" data-content="<?php echo Yii::t('category', "Краткое название страницы латинскими буквами, используется для формирования её адреса.<br /><br /> Например (выделено темным фоном): <pre>http://site.ru/news/<span class='label'>contacts</span>/</pre> Если вы не знаете, для чего вам нужно это поле &ndash; не заполняйте его, заголовка страницы будет достаточно.") ?>" data-original-title="<?php echo $model->getAttributeLabel('alias'); ?>" >
        <?php echo $form->labelEx($model, 'alias'); ?>
        <?php echo $form->textField($model, 'alias', array( 'size' => 60, 'maxlength'   => 150, 'placeholder' => Yii::t('news', 'Оставьте пустым для автоматической генерации') )); ?>
    </div>
    <div class="span5">
        <?php echo $form->error($model, 'alias'); ?>
    </div>
</div>


<div class="row-fluid control-group <?php echo $model->hasErrors('image') ? 'error' : '' ?>">
    <div class="span7  popover-help"  data-original-title="<?php echo $model->getAttributeLabel('image'); ?>" >
<?php echo $form->labelEx($model, 'image'); ?>
        <?php if(!$model->isNewRecord && $model->image):?>
            <?php echo CHtml::image(Yii::app()->baseUrl.'/'.Yii::app()->getModule('yupe')->uploadPath . DIRECTORY_SEPARATOR . $this->module->uploadPath.DIRECTORY_SEPARATOR.$model->image, $model->title,array('width' => 300,'height' => 300));?>
            <br/>
        <?php endif;?>

        <?php echo $form->fileField($model, 'image'); ?>
    </div>
    <div class="span5">
<?php echo $form->error($model, 'image'); ?>
    </div>
</div>



<?php
$items = array( );
foreach ($langs as $l)
    $items[] = array( 'label'       => "[" . $l . "] " . mb_convert_case(Yii::app()->locale->getLocaleDisplayName($l), MB_CASE_TITLE, 'UTF-8'), 'url'         => '#tab-' . $l, 'linkOptions' => array( "data-toggle" => "tab" ), 'active'      => $l == $model->lang );

$this->widget('bootstrap.widgets.TbMenu', array(
    'type'        => 'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'     => false, // whether this is a stacked menu
    'items'       => $items,
    'htmlOptions' => array( 'style' => 'margin-bottom:0;' ),
));
Yii::app()->clientScript->registerScript('fieldset', "
    $('document').ready(function () {
        $('.popover-help').popover({ 'delay': 500, });
    });
");


echo CHtml::openTag("div", array( "class" => "tab-content", 'style' => 'background-color: whiteSmoke; padding: 5px; border-bottom: 1px solid #DDD; border-left: 1px solid #DDD; border-right: 1px solid #DDD;' ));
foreach ($langs as $l)
{
    echo CHtml::openTag("div", array( "class" => "tab-pane " . ($l == $model->lang ? "active" : ""), "id"    => "tab-" . $l ));
    echo $this->renderPartial('_mform', array( 'model' => $models[$l], 'form'  => $form ));
    echo CHtml::closeTag("div");
}
echo CHtml::closeTag("div");


echo CHtml::closeTag("fieldset");
echo "<br />";
echo CHtml::submitButton($model->isNewRecord ? Yii::t('category', 'Добавить категорию') : Yii::t('category', 'Сохранить категорию'), array('class' => 'btn btn-primary'));
$this->endWidget();
?>



