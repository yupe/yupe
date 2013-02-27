<?php
    $this->breadcrumbs = array(
        Yii::app()->getModule('category')->getCategory() => array(),
        Yii::t('CategoryModule.category', 'Категории') => array('/category/default/index'),
        $model->name => array('/category/default/view', 'id' => $model->id),
        Yii::t('CategoryModule.category', 'Редактирование'),
    );

    $this->pageTitle = Yii::t('CategoryModule.category', 'Категории - редактирование');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('CategoryModule.category', 'Управление категориями'), 'url' => array('/category/default/index')),
        array('icon' => 'plus-sign', 'label' =>  Yii::t('CategoryModule.category', 'Добавить категорию'), 'url' => array('/category/default/create')),
        array('label' => Yii::t('CategoryModule.category', 'Категория') . ' «' . mb_substr($model->name, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('CategoryModule.category', 'Редактирование категории'), 'url' => array(
            '/category/default/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('CategoryModule.category', 'Просмотреть категорию'), 'url' => array(
            '/category/default/view',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('CategoryModule.category', 'Удалить категорию'), 'url' => '#', 'linkOptions' => array(
            'submit' => array('/category/default/delete', 'id' => $model->id),
            'confirm' => Yii::t('CategoryModule.category', 'Вы уверены, что хотите удалить категорию?'),
            'csrf' => true,
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('CategoryModule.category', 'Редактирование категории'); ?><br />
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'category-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well', 'enctype' => 'multipart/form-data'),
    'inlineErrors'           => true,
));
?>

    <div class="alert alert-info">
        <?php echo Yii::t('CategoryModule.category', 'Поля, отмеченные'); ?>
        <span class="required">*</span> 
        <?php echo Yii::t('CategoryModule.category', 'обязательны.'); ?>
    </div>


    <div class='row-fluid control-group <?php echo $model->hasErrors("parent_id") ? "error" : ""; ?>'>
        <?php echo  $form->dropDownListRow($model, 'parent_id', CHtml::listData(Category::model()->findAll(), 'id', 'name'), array('empty' => Yii::t('CategoryModule.category', '--нет--'),'class' => 'span7')); ?>
    </div>

    <div class='control-group <?php echo $model->hasErrors("alias") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'alias', array('class' => 'span7', 'maxlength' => 300)); ?>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('image') ? 'error' : '' ?>">
        <div class="span7  popover-help"  data-original-title="<?php echo $model->getAttributeLabel('image'); ?>" >
    <?php echo $form->labelEx($model, 'image'); ?>
            <?php if(!$model->isNewRecord && $model->image):?>
                <?php echo CHtml::image(Yii::app()->baseUrl.'/'.Yii::app()->getModule('yupe')->uploadPath . DIRECTORY_SEPARATOR . $this->module->uploadPath.DIRECTORY_SEPARATOR.$model->image, $model->name,array('width' => 300,'height' => 300));?>
                <br/>
            <?php endif;?>
            <?php echo $form->fileField($model, 'image'); ?>
        </div>
        <div class="span5">
    <?php echo $form->error($model, 'image'); ?>
        </div>
    </div>
    <?php
    $items = array();
    foreach ($langs as $l)
        $items[] = array(
            'label'  => "[" . $l . "] " . mb_convert_case(Yii::app()->locale->getLocaleDisplayName($l), MB_CASE_TITLE, 'UTF-8'),
            'url'    => '#tab-' . $l, 'linkOptions' => array("data-toggle" => "tab"),
            'active' => $l == $model->lang,
        );

    $this->widget('bootstrap.widgets.TbMenu', array(
        'type'        => 'tabs', // '', 'tabs', 'pills' (or 'list')
        'stacked'     => false, // whether this is a stacked menu
        'items'       => $items,
        'htmlOptions' => array('style' => 'margin-bottom:0;'),
    ));

    echo CHtml::openTag("div", array(
        "class" => "tab-content",
        'style' => 'background-color: whiteSmoke; padding: 5px; border-bottom: 1px solid #DDD; border-left: 1px solid #DDD; border-right: 1px solid #DDD;',
    ));
    foreach ($langs as $l)
    {
        echo CHtml::openTag("div", array(
            "class" => "tab-pane " . ($l == $model->lang ? "active" : ""),
            "id"    => "tab-" . $l,
        ));
        echo $this->renderPartial('_mform', array('model' => $models[$l], 'form' => $form));
        echo CHtml::closeTag("div");
    }
    ?>
<br/>
<?php
echo CHtml::submitButton($model->isNewRecord ? Yii::t('CategoryModule.category', 'Добавить категорию') : Yii::t('CategoryModule.category', 'Сохранить категорию'), array('class' => 'btn btn-primary'));
$this->endWidget();
?>
