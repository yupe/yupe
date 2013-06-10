<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'menu-item-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well'),
    'inlineErrors'           => true,
)); ?>
    <div class="alert alert-info">
        <?php echo Yii::t('MenuModule.menu', 'Поля, отмеченные'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('MenuModule.menu', 'обязательны.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

<div class="wide row-fluid control-group <?php echo ($model->hasErrors('menu_id') || $model->hasErrors('parent_id')) ? 'error' : ''; ?>">
    <?php
    $menu_id   = '#' . CHtml::activeId($model, 'menu_id');
    $parent_id = '#' . CHtml::activeId($model, 'parent_id');
    ?>
    <div class="span3">
        <?php echo $form->dropDownListRow($model, 'menu_id', CHtml::listData(Menu::model()->findAll(), 'id', 'name'), array(
            'empty'               => Yii::t('MenuModule.menu', '--выберите меню--'),
            'class'               => 'popover-help',
            'data-original-title' => $model->getAttributeLabel('menu_id'),
            'data-content'        => $model->getAttributeDescription('menu_id'),
            'ajax' => array(
                'type'       => 'POST',
                'url'        => $this->createUrl('/menu/menuitem/dynamicparent', (!$model->isNewRecord ? array('id' => $model->id) : array())),
                'update'     => $parent_id,
                'beforeSend' => "function() {
                            $('" . $parent_id . "').attr('disabled', true);
                            if ($('" . $menu_id . " option:selected').val() == '')
                                return false;
                        }",
                'complete'   => "function() {
                            $('" . $parent_id . "').attr('disabled', false);
                        }",
            ),
        )); ?>
    </div>
    <div class="span4">
        <?php echo $form->dropDownListRow($model, 'parent_id', $model->parentTree, array('disabled' => ($model->menu_id) ? false : true) + array('encode' => false, 'class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('parent_id'), 'data-content' => $model->getAttributeDescription('parent_id'))); ?>
    </div>
</div>

    <div class="row-fluid control-group <?php echo $model->hasErrors("title") ? "error" : ""; ?>">
        <?php echo $form->textFieldRow($model, 'title', array('class' => 'popover-help span7', 'maxlength' => 255, 'data-original-title' => $model->getAttributeLabel('title'), 'data-content' => $model->getAttributeDescription('title'))); ?>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors("href") ? "error" : ""; ?>">
        <?php echo $form->textFieldRow($model, 'href', array('class' => 'popover-help span7', 'maxlength' => 255, 'data-original-title' => $model->getAttributeLabel('href'), 'data-content' => $model->getAttributeDescription('href'))); ?>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors("sort") ? "error" : ""; ?>">
        <?php echo $form->textFieldRow($model, 'sort', array('class' => 'popover-help span7', 'maxlength' => 255, 'data-original-title' => $model->getAttributeLabel('sort'), 'data-content' => $model->getAttributeDescription('sort'))); ?>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('status') ? 'error' : ''; ?>">
        <?php echo $form->dropDownListRow($model, 'status', $model->statusList, array('class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('status'), 'data-content' => $model->getAttributeDescription('status'))); ?>
    </div>

     <div class="row-fluid control-group <?php echo $model->hasErrors("regular_link") ? "error" : ""; ?>">
         <?php echo $form->checkBoxRow($model, 'regular_link', array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('regular_link'), 'data-content' => $model->getAttributeDescription('regular_link'))); ?>
    </div>

    <?php $collapse = $this->beginWidget('bootstrap.widgets.TbCollapse');?>
    <div class="accordion-group">
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                <?php echo Yii::t('MenuModule.menu','Расширенные параметры');?>
            </a>
        </div>
        <div id="collapseOne" class="accordion-body collapse">
            <div class="accordion-inner">
                <div class="row-fluid control-group <?php echo $model->hasErrors("title_attr") ? "error" : ""; ?>">
                    <?php echo $form->textFieldRow($model, 'title_attr', array('class' => 'popover-help span7', 'maxlength' => 255, 'data-original-title' => $model->getAttributeLabel('title_attr'), 'data-content' => $model->getAttributeDescription('title_attr'))); ?>
                </div>
                <div class="row-fluid control-group <?php echo $model->hasErrors("class") ? "error" : ""; ?>">
                    <?php echo $form->textFieldRow($model, 'class', array('class' => 'popover-help span7', 'maxlength' => 50, 'data-original-title' => $model->getAttributeLabel('class'), 'data-content' => $model->getAttributeDescription('class'))); ?>
                </div>
                <div class="wide row-fluid control-group <?php echo ($model->hasErrors('before_link') || $model->hasErrors('after_link')) ? 'error' : ''; ?>">
                    <div class="span3">
                        <?php echo $form->textFieldRow($model, 'before_link', array('class' => 'popover-help span7', 'maxlength' => 255, 'data-original-title' => $model->getAttributeLabel('before_link'), 'data-content' => $model->getAttributeDescription('before_link'))); ?>
                    </div>
                    <div class="span4">
                        <?php echo $form->textFieldRow($model, 'after_link', array('class' => 'popover-help span7', 'maxlength' => 255, 'data-original-title' => $model->getAttributeLabel('after_link'), 'data-content' => $model->getAttributeDescription('after_link'))); ?>
                    </div>
                </div>
                <div class="wide row-fluid control-group <?php echo ($model->hasErrors('target') || $model->hasErrors('rel')) ? 'error' : ''; ?>">
                    <div class="span3">
                        <?php echo $form->textFieldRow($model, 'target', array('class' => 'popover-help span7', 'maxlength' => 10, 'data-original-title' => $model->getAttributeLabel('target'), 'data-content' => $model->getAttributeDescription('target'))); ?>
                    </div>
                    <div class="span4">
                        <?php echo $form->textFieldRow($model, 'rel', array('class' => 'popover-help span7', 'maxlength' => 10, 'data-original-title' => $model->getAttributeLabel('rel'), 'data-content' => $model->getAttributeDescription('rel'))); ?>
                    </div>
                </div>
                <div class="wide row-fluid control-group <?php echo ($model->hasErrors('condition_name') || $model->hasErrors('condition_denial')) ? 'error' : ''; ?>">
                    <div class="span4">
                        <?php echo $form->dropDownListRow($model, 'condition_name', $model->conditionList, array('empty' => '', 'class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('condition_name'), 'data-content' => $model->getAttributeDescription('condition_name'))); ?>
                    </div>
                    <div class="span3">
                        <?php echo $form->dropDownListRow($model, 'condition_denial', $model->conditionDenialList, array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('condition_denial'), 'data-content' => $model->getAttributeDescription('condition_denial'))); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <?php $this->endWidget();?>

    <br/>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('MenuModule.menu', 'Добавить пункт меню и продолжить') : Yii::t('MenuModule.menu', 'Сохранить пункт меню и продолжить'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'  => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label'       => $model->isNewRecord ? Yii::t('MenuModule.menu', 'Добавить пункт меню и закрыть') : Yii::t('MenuModule.menu', 'Сохранить пункт меню и закрыть'),
    )); ?>

<?php $this->endWidget(); ?>
