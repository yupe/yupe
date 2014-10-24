<script type='text/javascript'>
    $(document).ready(function () {
        $('#page-form').liTranslit({
            elName: '#Page_title',
            elAlias: '#Page_slug'
        });

        $('#menu_id').change(function () {
            var menuId = parseInt($(this).val());
            if (menuId) {
                $.post('<?php echo Yii::app()->createUrl('/menu/menuitemBackend/getjsonitems/') ?>', {
                    '<?php echo Yii::app()->getRequest()->csrfTokenName;?>': '<?php echo Yii::app()->getRequest()->csrfToken;?>',
                    'menuId': menuId
                }, function (response) {
                    if (response.result) {
                        var option = false;
                        var current = <?php echo (int) $menuParentId; ?>;
                        $.each(response.data, function (index, element) {
                            if (index == current) {
                                option = true;
                            } else {
                                option = false;
                            }
                            $('#parent_id').append(new Option(element, index, option));
                        })
                        if(current) {
                            $('#parent_id').val(current);
                        }
                        $('#parent_id').removeAttr('disabled');
                        $('#pareData').show();
                    }
                });
            }
        });

        if ($('#menu_id').val() > 0) {
            $('#menu_id').trigger('change');
        }
    })
</script>

<?php
/**
 * Отображение для default/_form:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                     => 'page-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'htmlOptions'            => array('class' => 'well'),
    )
); ?>
<div class="alert alert-info">
    <?php echo Yii::t('PageModule.page', 'Fields with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('PageModule.page', 'are required.'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<?php if (Yii::app()->hasModule('menu')): { ?>
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group">
                <?php echo CHtml::label(Yii::t('PageModule.page', 'Menu'), 'menu_id'); ?>
                <?php echo CHtml::dropDownList(
                    'menu_id',
                    $menuId,
                    CHtml::listData(Menu::model()->active()->findAll(array('order' => 'name DESC')), 'id', 'name'),
                    array('empty' => Yii::t('PageModule.page', '-choose-'), 'class' => 'form-control')
                ); ?>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <div id="pareData" style='display:none;'>
                    <?php echo CHtml::label(Yii::t('PageModule.page', 'Parent menu item'), 'parent_id'); ?>
                    <?php echo CHtml::dropDownList(
                        'parent_id',
                        $menuParentId,
                        array('0' => Yii::t('PageModule.page', 'Root')),
                        array(
                            'disabled' => true,
                            'empty'    => Yii::t('PageModule.page', '-choose-'),
                            'class'    => 'form-control'
                        )
                    ); ?>
                </div>
            </div>
        </div>
    </div>
<?php } endif ?>

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup(
            $model,
            'title_short',
            array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'data-original-title' => $model->getAttributeLabel('title_short'),
                        'data-content'        => $model->getAttributeDescription('title_short')
                    ),
                ),
            )
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup(
            $model,
            'title',
            array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'data-original-title' => $model->getAttributeLabel('title'),
                        'data-content'        => $model->getAttributeDescription('title')
                    ),
                ),
            )
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup(
            $model,
            'slug',
            array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('slug'),
                        'data-content'        => $model->getAttributeDescription('slug'),
                        'placeholder'         => Yii::t(
                                'PageModule.page',
                                'For automatic generation leave this field empty'
                            ),
                    ),
                ),
            )
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->checkBoxGroup(
            $model,
            'is_protected',
            array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('is_protected'),
                        'data-content'        => $model->getAttributeDescription('is_protected')
                    ),
                ),
            )
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 popover-help" data-original-title='<?php echo $model->getAttributeLabel('body'); ?>'
         data-content='<?php echo $model->getAttributeDescription('body'); ?>'>
        <?php echo $form->labelEx($model, 'body'); ?>
        <?php
        $this->widget(
            $this->module->getVisualEditor(),
            array(
                'model'     => $model,
                'attribute' => 'body',
            )
        ); ?>
    </div>
</div>

<br/>

<div class="row">
<div class="col-sm-12">
<?php $collapse = $this->beginWidget('bootstrap.widgets.TbCollapse'); ?>
<div class="panel-group" id="extended-options">
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <a data-toggle="collapse" data-parent="#extended-options" href="#collapseOne">
                <?php echo Yii::t('PageModule.page', 'More options'); ?>
            </a>
        </div>
    </div>
    <div id="collapseOne" class="panel-collapse collapse">
        <div class="panel-body">
            <div class="row">
                <?php if (count($languages) > 1) : { ?>
                    <div class="col-sm-4">
                        <?php echo $form->dropDownListGroup(
                            $model,
                            'lang',
                            array(
                                'widgetOptions' => array(
                                    'data'        => $languages,
                                    'htmlOptions' => array(
                                        'class' => 'popover-help',
                                        'empty' => Yii::t('PageModule.page', '--choose--')
                                    ),
                                ),
                            )
                        ); ?>
                    </div>
                    <div class="col-sm-4">
                        <br/>
                        <?php if (!$model->isNewRecord) : { ?>
                            <?php foreach ($languages as $k => $v) : { ?>
                                <?php if ($k !== $model->lang) : { ?>
                                    <?php if (empty($langModels[$k])) : { ?>
                                        <a href="<?php echo $this->createUrl(
                                            '/page/pageBackend/create',
                                            array('id' => $model->id, 'lang' => $k)
                                        ); ?>"><i class="iconflags iconflags-<?php echo $k; ?>"
                                                  title="<?php echo Yii::t(
                                                      'PageModule.page',
                                                      'Add translation for {lang}',
                                                      array('{lang}' => $v)
                                                  ); ?>"></i></a>
                                    <?php } else : { ?>
                                        <a href="<?php echo $this->createUrl(
                                            '/page/pageBackend/update',
                                            array('id' => $langModels[$k])
                                        ); ?>"><i class="iconflags iconflags-<?php echo $k; ?>"
                                                  title="<?php echo Yii::t(
                                                      'PageModule.page',
                                                      'Edit translation for {lang} language',
                                                      array('{lang}' => $v)
                                                  ); ?>"></i></a>
                                    <?php } endif; ?>
                                <?php } endif; ?>
                            <?php } endforeach; ?>
                        <?php } endif; ?>
                    </div>
                <?php } else : { ?>
                    <?php echo $form->hiddenField($model, 'lang'); ?>
                <?php } endif; ?>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?php echo $form->dropDownListGroup(
                        $model,
                        'layout',
                        array(
                            'widgetOptions' => array(
                                'data'        => Yii::app()->getModule('yupe')->getLayoutsList(),
                                'htmlOptions' => array(
                                    'class'               => 'popover-help',
                                    'empty'               => Yii::t('PageModule.page', '--choose--'),
                                    'data-original-title' => $model->getAttributeLabel('layout'),
                                    'data-content'        => $model->getAttributeDescription('layout'),
                                ),
                            ),
                        )
                    ); ?>
                </div>
                <div class="col-sm-4">
                    <?php echo $form->textFieldGroup(
                        $model,
                        'view',
                        array(
                            'widgetOptions' => array(
                                'htmlOptions' => array(
                                    'class'               => 'popover-help',
                                    'data-original-title' => $model->getAttributeLabel('view'),
                                    'data-content'        => $model->getAttributeDescription('view'),
                                ),
                            ),
                        )
                    ); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?php echo $form->dropDownListGroup(
                        $model,
                        'category_id',
                        array(
                            'widgetOptions' => array(
                                'data'        => Category::model()->getFormattedList(),
                                'htmlOptions' => array(
                                    'class'               => 'popover-help',
                                    'empty'               => Yii::t('PageModule.page', '--choose--'),
                                    'data-original-title' => $model->getAttributeLabel('category_id'),
                                    'data-content'        => $model->getAttributeDescription('category_id'),
                                    'encode'              => false
                                ),
                            ),
                        )
                    ); ?>
                </div>
                <div class="col-sm-4">
                    <?php echo $form->dropDownListGroup(
                        $model,
                        'parent_id',
                        array(
                            'widgetOptions' => array(
                                'data'        => $pages,
                                'htmlOptions' => array(
                                    'class'               => 'popover-help',
                                    'empty'               => Yii::t('PageModule.page', '--choose--'),
                                    'data-original-title' => $model->getAttributeLabel('parent_id'),
                                    'data-content'        => $model->getAttributeDescription('parent_id'),
                                ),
                            ),
                        )
                    ); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <?php echo $form->dropDownListGroup(
                        $model,
                        'status',
                        array(
                            'widgetOptions' => array(
                                'data'        => $model->statusList,
                                'htmlOptions' => array(
                                    'class'               => 'popover-help',
                                    'empty'               => Yii::t('PageModule.page', '--choose--'),
                                    'data-original-title' => $model->getAttributeLabel('status'),
                                    'data-content'        => $model->getAttributeDescription('status'),
                                    'data-container'      => 'body',
                                ),
                            ),
                        )
                    ); ?>
                </div>
                <div class="col-sm-1">
                    <?php echo $form->textFieldGroup(
                        $model,
                        'order',
                        array(
                            'widgetOptions' => array(
                                'htmlOptions' => array(
                                    'class'               => 'popover-help',
                                    'data-original-title' => $model->getAttributeLabel('order'),
                                    'data-content'        => $model->getAttributeDescription('order'),
                                ),
                            ),
                        )
                    ); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <a data-toggle="collapse" data-parent="#extended-options" href="#collapseTwo">
                <?php echo Yii::t('PageModule.page', 'Data for SEO'); ?>
            </a>
        </div>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse">
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-7">
                    <?php echo $form->textFieldGroup(
                        $model,
                        'keywords',
                        array(
                            'widgetOptions' => array(
                                'htmlOptions' => array(
                                    'class'               => 'popover-help',
                                    'data-original-title' => $model->getAttributeLabel('keywords'),
                                    'data-content'        => $model->getAttributeDescription('keywords'),
                                ),
                            ),
                        )
                    ); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-7">
                    <?php echo $form->textAreaGroup(
                        $model,
                        'description',
                        array(
                            'widgetOptions' => array(
                                'htmlOptions' => array(
                                    'rows'                => 8,
                                    'class'               => 'popover-help',
                                    'data-original-title' => $model->getAttributeLabel('description'),
                                    'data-content'        => $model->getAttributeDescription('description'),
                                ),
                            ),
                        )
                    ); ?>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php $this->endWidget(); ?>
</div>
</div>

<br/><br/>

<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('PageModule.page', 'Create page and continue') : Yii::t(
                'PageModule.page',
                'Save page and continue'
            ),
    )
); ?>

<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType'  => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label'       => $model->isNewRecord ? Yii::t('PageModule.page', 'Create page and close') : Yii::t(
                'PageModule.page',
                'Save page and close'
            ),
    )
); ?>

<?php $this->endWidget(); ?>
