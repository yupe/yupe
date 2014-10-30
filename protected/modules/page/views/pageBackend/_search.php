<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'action'      => Yii::app()->createUrl($this->route),
        'method'      => 'get',
        'htmlOptions' => array('class' => 'well'),
    )
); ?>
<fieldset class="inline">
    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'parent_id',
                array(
                    'widgetOptions' => array(
                        'data'        => $pages,
                        'htmlOptions' => array(
                            'class' => 'popover-help',
                            'empty' => Yii::t('PageModule.page', '- not set -')
                        ),
                    ),
                )
            ); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'status',
                array(
                    'widgetOptions' => array(
                        'data'        => $model->statusList,
                        'htmlOptions' => array(
                            'class' => 'popover-help',
                            'empty' => Yii::t('PageModule.page', '- no matter -')
                        ),
                    ),
                )
            ); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'slug'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'title'); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'title_short'); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'keywords'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'description'); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'category_id',
                array(
                    'widgetOptions' => array(
                        'data'        => Category::model()->getFormattedList(
                                (int)Yii::app()->getModule('page')->mainCategory
                            ),
                        'htmlOptions' => array(
                            'class' => 'popover-help',
                            'empty' => Yii::t('PageModule.page', '- not set -')
                        ),
                    ),
                )
            ); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup($model, 'body'); ?>
        </div>
    </div>

</fieldset>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType'  => 'submit',
        'context'     => 'primary',
        'encodeLabel' => false,
        'label'       => '<i class="fa fa-search">&nbsp;</i> ' . Yii::t('PageModule.page', 'Find pages'),
    )
); ?>

<?php $this->endWidget(); ?>
