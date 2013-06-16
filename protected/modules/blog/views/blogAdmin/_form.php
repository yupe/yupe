<script type='text/javascript'>
    $(document).ready(function () {
        $('#post-form').liTranslit({
            elName: '#Blog_name',
            elAlias: '#Blog_slug'
        });
    })
</script>


<?php
/**
 * Отображение для BlogAdmin/_form:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
        'id'                     => 'blog-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => array('class' => 'well', 'enctype'=>'multipart/form-data'),
        'inlineErrors'           => true,
    )
);

?>
    <div class="alert alert-info">
        <?php echo Yii::t('BlogModule.blog', 'Поля, отмеченные'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('BlogModule.blog', 'обязательны.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class="row-fluid control-group <?php echo $model->hasErrors('category_id') ? 'error' : ''; ?>">
        <?php echo $form->dropDownListRow($model, 'category_id', CHtml::listData($this->module->getCategoryList(),'id','name') , array('empty' => Yii::t('BlogModule.blog','--выберите--'),'class' => 'popover-help span7', 'maxlength' => 11,'data-original-title' => $model->getAttributeLabel('category_id'), 'data-content' => $model->getAttributeDescription('category_id'))); ?>
    </div>

    <div class="wide row-fluid control-group <?php echo ($model->hasErrors('type') || $model->hasErrors('status')) ? 'error' : ''; ?>">
        <div class="span3">
            <?php echo $form->dropDownListRow($model, 'type', $model->getTypeList(), array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('type'), 'data-content' => $model->getAttributeDescription('type'))); ?>
        </div>
        <div class="span4">
            <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('status'), 'data-content' => $model->getAttributeDescription('status'))); ?>
        </div>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('name') ? 'error' : ''; ?>">
        <?php
        echo $form->textFieldRow(
            $model, 'name', array(
                'class'               => 'popover-help span7',
                'maxlength'           => 250,
                'size'                => 60,
                'data-original-title' => $model->getAttributeLabel('name'),
                'data-content'        => $model->getAttributeDescription('name'),
            )
        ); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('slug') ? 'error' : ''; ?>">
            <?php echo $form->textFieldRow($model, 'slug', array('class' => 'popover-help span7', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('slug'), 'data-content' => $model->getAttributeDescription('slug'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('icon') ? 'error' : ''; ?>">
        <div class="span7  popover-help"  data-original-title="<?php echo $model->getAttributeLabel('icon'); ?>">
            <?php if (!$model->isNewRecord && $model->icon): ?>
                <?php echo CHtml::image($model->getImageUrl(), $model->name, array('width'  => 64, 'height' => 64)); ?>
            <?php endif; ?>
            <?php echo $form->labelEx($model, 'icon'); ?>
            <?php echo $form->fileField($model, 'icon'); ?>
        </div>
        <div class="span5">
            <?php echo $form->error($model, 'icon'); ?>
        </div>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('description') ? 'error' : ''; ?>">
        <div class="popover-help" data-original-title='<?php echo $model->getAttributeLabel('description'); ?>' data-content='<?php echo $model->getAttributeDescription('description'); ?>'>
            <?php echo $form->labelEx($model, 'description'); ?>
            <?php
            $this->widget(
                $this->module->editor, array(
                    'model'       => $model,
                    'attribute'   => 'description',
                    'options'     => $this->module->editorOptions,
                )
            ); ?>
        </div>
    </div>
    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'type'       => 'primary',
            'label'      => $model->isNewRecord ? Yii::t('BlogModule.blog', 'Добавить блог и продолжить') : Yii::t('BlogModule.blog', 'Сохранить блог и продолжить'),
        )
    ); ?>
    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'buttonType'  => 'submit',
            'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
            'label'       => $model->isNewRecord ? Yii::t('BlogModule.blog', 'Добавить блог и закрыть') : Yii::t('BlogModule.blog', 'Сохранить блог и закрыть'),
        )
    ); ?>

<?php $this->endWidget(); ?>