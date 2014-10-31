<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'action'      => Yii::app()->createUrl($this->route),
        'method'      => 'get',
        'type'        => 'vertical',
        'htmlOptions' => array('class' => 'well'),
    )
); ?>

<fieldset>
    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->dropDownListGroup(
                $model,
                'category_id',
                array(
                    'widgetOptions' => array(
                        'data'        => CHtml::listData(Category::model()->published()->findAll(), 'id', 'name'),
                        'htmlOptions' => array(
                            'empty'               => Yii::t('CatalogModule.catalog', '--choose--'),
                            'class'               => 'popover-help',
                            'data-original-title' => $model->getAttributeLabel('category_id'),
                            'data-content'        => $model->getAttributeDescription('category_id')
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
                        'data'        => $model->getStatusList(),
                        'htmlOptions' => array(
                            'empty'               => Yii::t('CatalogModule.catalog', '--choose--'),
                            'class'               => 'popover-help',
                            'data-original-title' => $model->getAttributeLabel('status'),
                            'data-content'        => $model->getAttributeDescription('status')
                        ),
                    ),
                )
            ); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->checkBoxGroup(
                $model,
                'is_special',
                array(
                    'widgetOptions' => array(
                        'htmlOptions' => array(
                            'class'               => 'popover-help',
                            'data-original-title' => $model->getAttributeLabel('is_special'),
                            'data-content'        => $model->getAttributeDescription('is_special')
                        ),
                    ),
                )
            ); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup(
                $model,
                'price',
                array(
                    'widgetOptions' => array(
                        'htmlOptions' => array(
                            'class'               => 'popover-help',
                            'data-original-title' => $model->getAttributeLabel('price'),
                            'data-content'        => $model->getAttributeDescription('price')
                        ),
                    ),
                )
            ); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup(
                $model,
                'name',
                array(
                    'widgetOptions' => array(
                        'htmlOptions' => array(
                            'class'               => 'popover-help',
                            'data-original-title' => $model->getAttributeLabel('name'),
                            'data-content'        => $model->getAttributeDescription('namece')
                        ),
                    ),
                )
            ); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup(
                $model,
                'alias',
                array(
                    'widgetOptions' => array(
                        'htmlOptions' => array(
                            'class'               => 'popover-help',
                            'data-original-title' => $model->getAttributeLabel('alias'),
                            'data-content'        => $model->getAttributeDescription('aliase')
                        ),
                    ),
                )
            ); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup(
                $model,
                'article',
                array(
                    'widgetOptions' => array(
                        'htmlOptions' => array(
                            'class'               => 'popover-help',
                            'data-original-title' => $model->getAttributeLabel('article'),
                            'data-content'        => $model->getAttributeDescription('article')
                        ),
                    ),
                )
            ); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup(
                $model,
                'short_description',
                array(
                    'widgetOptions' => array(
                        'htmlOptions' => array(
                            'class'               => 'popover-help',
                            'data-original-title' => $model->getAttributeLabel('short_description'),
                            'data-content'        => $model->getAttributeDescription('short_description')
                        ),
                    ),
                )
            ); ?>
        </div>
        <div class="col-sm-3">
            <?php echo $form->textFieldGroup(
                $model,
                'description',
                array(
                    'widgetOptions' => array(
                        'htmlOptions' => array(
                            'class'               => 'popover-help',
                            'data-original-title' => $model->getAttributeLabel('description'),
                            'data-content'        => $model->getAttributeDescription('description')
                        ),
                    ),
                )
            ); ?>
        </div>
    </div>
</fieldset>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'context'     => 'primary',
        'encodeLabel' => false,
        'buttonType'  => 'submit',
        'label'       => '<i class="fa fa-search">&nbsp;</i> ' . Yii::t(
                'CatalogModule.catalog',
                'Find a product'
            ),
    )
); ?>

<?php $this->endWidget(); ?>
