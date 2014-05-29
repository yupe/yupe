<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'type' => 'vertical',
        'htmlOptions' => array('class' => 'well'),
    )
); ?>

<fieldset class="inline">
    <div class="row-fluid control-group">

        <div class="span3">
            <?php echo $form->dropDownListRow(
                $model,
                'category_id',
                CHtml::listData(Category::model()->published()->findAll(), 'id', 'name'),
                array(
                    'empty' => Yii::t('CatalogModule.catalog', '--choose--'),
                    'class' => 'popover-help',
                    'data-original-title' => $model->getAttributeLabel('category_id'),
                    'data-content' => $model->getAttributeDescription('category_id')
                )
            ); ?>
        </div>

        <div class="span3">
            <?php echo $form->dropDownListRow(
                $model,
                'status',
                $model->getStatusList(),
                array(
                    'class' => 'popover-help',
                    'data-original-title' => $model->getAttributeLabel('status'),
                    'data-content' => $model->getAttributeDescription('status'),
                    'empty' => Yii::t('CatalogModule.catalog', '--choose--'),
                )
            ); ?>
        </div>
        <div class="span3">
            <?php echo $form->checkBoxRow(
                $model,
                'is_special',
                array(
                    'class' => 'popover-help',
                    'data-original-title' => $model->getAttributeLabel('is_special'),
                    'data-content' => $model->getAttributeDescription('is_special')
                )
            ); ?>
        </div>
    </div>
    <div class="row-fluid control-group">

        <div class="span3">
            <?php echo $form->textFieldRow(
                $model,
                'price',
                array(
                    'class' => ' popover-help',
                    'size' => 60,
                    'maxlength' => 60,
                    'data-original-title' => $model->getAttributeLabel('price'),
                    'data-content' => $model->getAttributeDescription('price')
                )
            ); ?>
        </div>

        <div class="span3">
            <?php echo $form->textFieldRow(
                $model,
                'name',
                array(
                    'class' => ' popover-help',
                    'size' => 60,
                    'maxlength' => 150,
                    'data-original-title' => $model->getAttributeLabel('name'),
                    'data-content' => $model->getAttributeDescription('name')
                )
            ); ?>
        </div>
        <div class="span3">
            <?php echo $form->textFieldRow(
                $model,
                'alias',
                array(
                    'class' => ' popover-help',
                    'size' => 60,
                    'maxlength' => 100,
                    'data-original-title' => $model->getAttributeLabel('alias'),
                    'data-content' => $model->getAttributeDescription('alias')
                )
            ); ?>
        </div>
    </div>

    <div class="row-fluid control-group">

        <div class="span3">
            <?php echo $form->textFieldRow(
                $model,
                'article',
                array(
                    'class' => ' popover-help',
                    'size' => 60,
                    'maxlength' => 100,
                    'data-original-title' => $model->getAttributeLabel('article'),
                    'data-content' => $model->getAttributeDescription('article')
                )
            ); ?>
        </div>
        <div class="span3">
            <?php echo $form->textFieldRow(
                $model,
                'short_description',
                array(
                    'class' => ' popover-help',
                    'rows' => 6,
                    'cols' => 50,
                    'data-original-title' => $model->getAttributeLabel('short_description'),
                    'data-content' => $model->getAttributeDescription('short_description')
                )
            ); ?>
        </div>

        <div class="span3">
            <?php echo $form->textFieldRow(
                $model,
                'description',
                array(
                    'class' => ' popover-help',
                    'rows' => 6,
                    'cols' => 50,
                    'data-original-title' => $model->getAttributeLabel('description'),
                    'data-content' => $model->getAttributeDescription('description')
                )
            ); ?>
        </div>
    </div>

</fieldset>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'type' => 'primary',
        'encodeLabel' => false,
        'buttonType' => 'submit',
        'label' => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('CatalogModule.catalog', 'Find a product'),
    )
); ?>

<?php $this->endWidget(); ?>
