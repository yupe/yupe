<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('news')->getCategory() => array(),
        Yii::t('NewsModule.news', 'Новости') => array('/news/default/index'),
        $model->title => array('/news/default/view', 'id' => $model->id),
        Yii::t('NewsModule.news', 'Редактирование'),
    );

    $this->pageTitle = Yii::t('NewsModule.news', 'Новости - редактирование');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('NewsModule.news', 'Управление новостями'), 'url' => array('/news/default/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('NewsModule.news', 'Добавить новость'), 'url' => array('/news/default/create')),
        array('label' => Yii::t('NewsModule.news', 'Новость') . ' «' . mb_substr($model->title, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('NewsModule.news', 'Редактирование новости'), 'url' => array(
            '/news/default/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('NewsModule.news', 'Просмотреть новость'), 'url' => array(
            '/news/default/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('NewsModule.news', 'Удалить новость'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/news/default/delete', 'id' => $model->id),
            'confirm' => Yii::t('NewsModule.news', 'Вы уверены, что хотите удалить новость?'),
            'csrf' => true,
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('NewsModule.news', 'Редактирование новости'); ?><br />
        <small>&laquo;<?php echo $model->title; ?>&raquo;</small>
    </h1>
</div>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'news-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well', 'enctype'=>'multipart/form-data'),
    'inlineErrors'           => true,
));
echo CHtml::openTag("fieldset", array( "class" => "inline" ));
?>
    <div class="alert alert-info">
        <?php echo Yii::t('NewsModule.news', 'Поля, отмеченные'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('NewsModule.news', 'обязательны.'); ?>
    </div>


    <div class="row-fluid control-group <?php echo $model->hasErrors('date') ? 'error' : ''; ?>">
        <div class="span4 popover-help" data-original-title='<?php echo $model->getAttributeLabel('date'); ?>' data-content='<?php echo $model->getAttributeDescription('date'); ?>'>
            <?php
            echo $form->datepickerRow(
                $model, 'date', array(
                    'prepend' => '<i class="icon-calendar"></i>',
                    'options' => array(
                        'format'    => 'dd.mm.yyyy',
                        'weekStart' => 1,
                        'autoclose' => true,
                    ),
                    'class'   => 'span11'
                )
            ); ?>
        </div>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('category_id') ? 'error' : ''; ?>">
        <?php echo $form->dropDownListRow($model, 'category_id', CHtml::listData($this->module->getCategoryList(), 'id', 'name'), array('class' => 'span7 popover-help','empty' => Yii::t('NewsModule.news', '--выберите--'))); ?>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('alias') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'alias', array('size' => 60, 'maxlength' => 150, 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('alias'), 'data-content' => $model->getAttributeDescription('alias'))); ?>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('link') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'link', array('size' => 60, 'maxlength' => 150, 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('link'), 'data-content' => $model->getAttributeDescription('link'))); ?>
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
    <div class="row-fluid control-group <?php echo $model->hasErrors('is_protected') ? 'error' : '' ?>">
        <div class="span7  popover-help" data-content="<?php echo Yii::t('NewsModule.news', "Страница будет видна только авторизованным пользователям") ?>" data-original-title="<?php echo $model->getAttributeLabel('is_protected'); ?>" >
            <?php echo $form->labelEx($model, 'is_protected'); ?>
            <?php echo $form->checkBox($model, 'is_protected'); ?>
        </div>
        <div class="span5">
            <?php echo $form->error($model, 'slug'); ?>
        </div>
    </div>

<?php
$items = array( );
foreach ($langs as $l)
    $items[] = array( 'label' => "[" . $l . "] " . mb_convert_case(Yii::app()->locale->getLocaleDisplayName($l), MB_CASE_TITLE, 'UTF-8'), 'url'         => '#tab-' . $l, 'linkOptions' => array( "data-toggle" => "tab" ), 'active'      => $l == $model->lang );

$this->widget('bootstrap.widgets.TbMenu', array(
    'type'        => 'tabs', // '', 'tabs', 'pills' (or 'list')
    'stacked'     => false, // whether this is a stacked menu
    'items'       => $items,
    'htmlOptions' => array( 'style' => 'margin-bottom:0;' ),
));

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
echo CHtml::submitButton($model->isNewRecord ? Yii::t('NewsModule.news', 'Добавить новость и продолжить редактирование') : Yii::t('NewsModule.news', 'Сохранить и продолжить редактирование'), array('class' => 'btn btn-primary'));
echo "&nbsp;";
echo CHtml::submitButton($model->isNewRecord ? Yii::t('NewsModule.news', 'Добавить и закрыть') : Yii::t('NewsModule.news', 'Сохранить и закрыть'), array( 'name'  => 'saveAndClose', 'id'    => 'saveAndClose', 'class' => 'btn btn-info' ));

$this->endWidget();
?>
