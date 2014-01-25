<script type='text/javascript'>
    $(document).ready(function(){
        $('#page-form').liTranslit({
            elName: '#Page_title',
            elAlias: '#Page_slug'
        });

        $('#menu_id').change(function(){
            var menuId = parseInt($(this).val());
            if(menuId){
                $.post('<?php echo Yii::app()->baseUrl;?>/menu/menuitem/getjsonitems/',{
                    '<?php echo Yii::app()->getRequest()->csrfTokenName;?>':'<?php echo Yii::app()->getRequest()->csrfToken;?>',
                    'menuId' : menuId
                },function(response){
                    if(response.result){
                        var option = false;
                        var current = <?php echo (int)$menuParentId; ?>;
                        $.each(response.data,function(index,element){
                            if(index == current){
                                option = true;
                            }  else {
                                option = false;
                            }
                            $('#parent_id').append(new Option(element,index,option));
                        })
                        $('#parent_id').removeAttr('disabled');
                        $('#pareData').show();
                    }
                });
            }
        });

        if($('#menu_id').val() > 0){
            $('#menu_id').trigger('change');
        }
    })
</script>

<?php
/**
 * Отображение для default/_form:
 * 
 *   @category YupeView
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
        'id'                     => 'page-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => array('class' => 'well'),
        'inlineErrors'           => true,
    )
); ?>
    <div class="alert alert-info">
        <?php echo Yii::t('PageModule.page', 'Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('PageModule.page', 'are required.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <?php if (count($languages) > 1) : ?>
        <?php echo $form->dropDownListRow($model, 'lang', $languages, array('class' => 'popover-help','empty' => Yii::t('PageModule.page', '--choose--'))); ?>
        <?php if (!$model->isNewRecord) : ?>
            <?php foreach ($languages as $k => $v) : ?>
                <?php if ($k !== $model->lang) : ?>
                    <?php if (empty($langModels[$k])) : ?>
                        <a href="<?php echo $this->createUrl('/page/pageBackend/create', array('id' => $model->id, 'lang'  => $k)); ?>"><i class="iconflags iconflags-<?php echo $k; ?>" title="<?php echo Yii::t('PageModule.page', 'Add translation for {lang}', array('{lang}' => $v)); ?>"></i></a>
                    <?php else : ?>
                        <a href="<?php echo $this->createUrl('/page/pageBackend/update', array('id' => $langModels[$k])); ?>"><i class="iconflags iconflags-<?php echo $k; ?>" title="<?php echo Yii::t('PageModule.page', 'Edit translation for {lang} language', array('{lang}' => $v)); ?>"></i></a>
                    <?php endif;?>
                <?php endif;?>
            <?php endforeach;?>
        <?php endif;?>
    <?php else : ?>
        <?php echo $form->hiddenField($model,'lang');?>
    <?php endif;?>

    <div class="wide row-fluid control-group <?php echo ($model->hasErrors('category_id') || $model->hasErrors('parent_id')) ? 'error' : ''; ?>">
        <div class="span4">
            <?php echo $form->dropDownListRow($model, 'category_id', Category::model()->getFormattedList(), array('empty' => Yii::t('PageModule.page', '--choose--'), 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('category_id'), 'data-content' => $model->getAttributeDescription('category_id'), 'encode' => false)); ?>
        </div>
        <div class="span3">
            <?php echo $form->dropDownListRow($model, 'parent_id', $pages, array('empty' => Yii::t('PageModule.page', '--choose--'), 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('parent_id'), 'data-content' => $model->getAttributeDescription('parent_id'))); ?>
        </div>
    </div>
    <div class="wide row-fluid control-group <?php echo ($model->hasErrors('status') || $model->hasErrors('order')) ? 'error' : ''; ?>">
        <div class="span4">
            <?php echo $form->dropDownListRow($model, 'status', $model->statusList, array('class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('status'), 'data-content' => $model->getAttributeDescription('status'))); ?>
        </div>
        <div class="span3">
            <?php echo $form->textFieldRow($model, 'order', array('size' => 10, 'maxlength' => 10, 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('order'), 'data-content' => $model->getAttributeDescription('order'))); ?>
        </div>
    </div>

    <?php if(Yii::app()->hasModule('menu')):?>
        <?php echo CHtml::label(Yii::t('PageModule.page','Menu'),'menu_id');?>
        <?php echo CHtml::dropDownList('menu_id',$menuId,CHtml::listData(Menu::model()->active()->findAll(array('order' => 'name DESC')),'id','name'),array('empty' => Yii::t('PageModule.page','-choose-')));?>

        <div id="pareData" style='display:none;'>
            <?php echo CHtml::label(Yii::t('PageModule.page','Parent menu item'),'parent_id');?>
            <?php echo CHtml::dropDownList('parent_id',$menuParentId,array('0' => Yii::t('PageModule.page','Root')),array('disabled' => true,'empty' => Yii::t('PageModule.page','-choose-')));?>
        </div>
    <?php endif?>

     <div class="row-fluid control-group <?php echo $model->hasErrors('layout') ? 'error' : ''; ?>">
        <?php echo $form->dropDownListRow($model, 'layout', Yii::app()->getModule('yupe')->getLayoutsList() , array('empty' => '-----','maxlength' => 150, 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('layout'), 'data-content' => $model->getAttributeDescription('layout'))); ?>
    </div>    

    <div class="row-fluid control-group <?php echo $model->hasErrors('title_short') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'title_short', array('size' => 60, 'maxlength' => 150, 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('title_short'), 'data-content' => $model->getAttributeDescription('title_short'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('title') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'title', array('size' => 60, 'maxlength' => 150, 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('title'), 'data-content' => $model->getAttributeDescription('title'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('slug') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'slug', array('size' => 60, 'maxlength' => 150, 'placeholder' => Yii::t('PageModule.page', 'For automatic generation leave this field empty'), 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('slug'), 'data-content' => $model->getAttributeDescription('slug'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('is_protected') ? 'error' : ''; ?>">
        <?php echo $form->checkBoxRow($model, 'is_protected', array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('is_protected'), 'data-content' => $model->getAttributeDescription('is_protected'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('body') ? 'error' : ''; ?>">
        <div class="popover-help" data-original-title='<?php echo $model->getAttributeLabel('body'); ?>' data-content='<?php echo $model->getAttributeDescription('body'); ?>'>
            <?php echo $form->labelEx($model, 'body'); ?>
            <?php
            $this->widget(
                $this->module->editor, array(
                    'model'       => $model,
                    'attribute'   => 'body',
                    'options'     => $this->module->editorOptions,
                )
            ); ?>
        </div>
    </div>

    <?php $collapse = $this->beginWidget('bootstrap.widgets.TbCollapse');?>
    <div class="accordion-group">
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                <?php echo Yii::t('PageModule.page', 'Data for SEO');?>
            </a>
        </div>
        <div id="collapseOne" class="accordion-body collapse">
            <div class="accordion-inner">
                <div class="row-fluid control-group <?php echo $model->hasErrors('keywords') ? 'error' : ''; ?>">
                    <?php echo $form->textFieldRow($model, 'keywords', array('size' => 60, 'maxlength' => 150, 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('keywords'), 'data-content' => $model->getAttributeDescription('keywords'))); ?>
                </div>
                <div class="row-fluid control-group <?php echo $model->hasErrors('description') ? 'error' : ''; ?>">
                    <?php echo $form->textAreaRow($model, 'description', array('rows' => 3, 'cols' => 98, 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('description'), 'data-content' => $model->getAttributeDescription('description'))); ?>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endWidget();?>

    <br/><br/>

    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'type'       => 'primary',
            'label'      => $model->isNewRecord ? Yii::t('PageModule.page', 'Create page and continue') : Yii::t('PageModule.page', 'Save page and continue'),
        )
    ); ?>
    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'htmlOptions'=> array('name' => 'submit-type', 'value' => 'index'),
            'label'      => $model->isNewRecord ? Yii::t('PageModule.page', 'Create page and close') : Yii::t('PageModule.page', 'Save page and close'),
        )
    ); ?>

<?php $this->endWidget(); ?>
