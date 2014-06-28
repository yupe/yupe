<ul class="nav nav-tabs">
    <li class="active"><a href="#coupon" data-toggle="tab">Купон</a></li>
    <li><a href="#history" data-toggle="tab">История покупок</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="coupon">
        <?php
        /* @var $model Coupon */
        $form = $this->beginWidget(
            'bootstrap.widgets.TbActiveForm', array(
                'id' => 'coupon-form',
                'enableAjaxValidation' => false,
                'enableClientValidation' => true,
                'type' => 'vertical',
                'htmlOptions' => array('class' => 'well'),
                'inlineErrors' => true,
            )
        );
        ?>
        <div class="alert alert-info">
            <?php echo Yii::t('ShopModule.coupon', 'Поля, отмеченные'); ?>
            <span class="required">*</span>
            <?php echo Yii::t('ShopModule.coupon', 'обязательны.'); ?>
        </div>

        <?php echo $form->errorSummary($model); ?>
        <div class="wide row-fluid control-group <?php echo $model->hasErrors('status') ? 'error' : ''; ?>">
            <div class="span4">
                <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('class' => '', 'data-original-title' => $model->getAttributeLabel('status'), 'data-content' => $model->getAttributeDescription('status'))); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model->hasErrors('name') ? 'error' : ''; ?>">
            <?php echo $form->textFieldRow($model, 'name', array('class' => 'span7', 'size' => 60, 'maxlength' => 250, 'data-original-title' => $model->getAttributeLabel('name'), 'data-content' => $model->getAttributeDescription('name'))); ?>
        </div>
        <div class="row-fluid control-group <?php echo $model->hasErrors('code') ? 'error' : ''; ?>">
            <?php echo $form->textFieldRow($model, 'code', array('class' => 'span7', 'size' => 60, 'maxlength' => 250, 'data-original-title' => $model->getAttributeLabel('code'), 'data-content' => $model->getAttributeDescription('code'))); ?>
        </div>

        <div class="row-fluid control-group <?php echo $model->hasErrors('type') ? 'error' : ''; ?>">
            <?php echo $form->dropDownListRow($model, 'type', $model->getTypeList(), array('class' => '', 'data-original-title' => $model->getAttributeLabel('type'), 'data-content' => $model->getAttributeDescription('type'))); ?>
        </div>
        <div class="row-fluid control-group <?php echo $model->hasErrors('value') ? 'error' : ''; ?>">
            <?php echo $form->textFieldRow($model, 'value', array('class' => 'span2', 'data-original-title' => $model->getAttributeLabel('value'), 'data-content' => $model->getAttributeDescription('value'))); ?>
        </div>
        <div class="row-fluid control-group <?php echo $model->hasErrors('min_order_price') ? 'error' : ''; ?>">
            <?php echo $form->textFieldRow($model, 'min_order_price', array('class' => 'span2', 'data-original-title' => $model->getAttributeLabel('min_order_price'), 'data-content' => $model->getAttributeDescription('min_order_price'))); ?>
        </div>
        <div class="row-fluid control-group <?php echo $model->hasErrors('registered_user') ? 'error' : ''; ?>">
            <?php echo $form->dropDownListRow($model, 'registered_user', array(0 => 'Нет', 1 => 'Да'), array('class' => '', 'data-original-title' => $model->getAttributeLabel('registered_user'), 'data-content' => $model->getAttributeDescription('registered_user'))); ?>
        </div>

        <div class="row-fluid control-group <?php echo $model->hasErrors('free_shipping') ? 'error' : ''; ?>">
            <?php echo $form->dropDownListRow($model, 'free_shipping', array(0 => 'Нет', 1 => 'Да'), array('class' => '', 'data-original-title' => $model->getAttributeLabel('free_shipping'), 'data-content' => $model->getAttributeDescription('free_shipping'))); ?>
        </div>

        <div class="row-fluid">
            <div class="span2 popover-help" data-original-title='<?php echo $model->getAttributeLabel('date_start'); ?>'
                 data-content='<?php echo $model->getAttributeDescription('date_start'); ?>'>
                <?php
                echo $form->datePickerRow(
                    $model,
                    'date_start',
                    array(
                        'options' => array(
                            'format' => 'yyyy-mm-dd',
                            'weekStart' => 1,
                            'autoclose' => true,
                        ),
                        'htmlOptions' => array(
                            'class' => 'span12'
                        ),
                    ),
                    array(
                        'prepend' => '<i class="icon-calendar"></i>',
                    )
                ); ?>
            </div>
            <div class="span2 popover-help" data-original-title='<?php echo $model->getAttributeLabel('date_end'); ?>'
                 data-content='<?php echo $model->getAttributeDescription('date_end'); ?>'>
                <?php
                echo $form->datePickerRow(
                    $model,
                    'date_end',
                    array(
                        'options' => array(
                            'format' => 'yyyy-mm-dd',
                            'weekStart' => 1,
                            'autoclose' => true,
                        ),
                        'htmlOptions' => array(
                            'class' => 'span12'
                        ),
                    ),
                    array(
                        'prepend' => '<i class="icon-calendar"></i>',
                    )
                ); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model->hasErrors('quantity') ? 'error' : ''; ?>">
            <?php echo $form->textFieldRow($model, 'quantity', array('class' => 'span2', 'data-original-title' => $model->getAttributeLabel('quantity'), 'data-content' => $model->getAttributeDescription('quantity'))); ?>
        </div>
        <div class="row-fluid control-group <?php echo $model->hasErrors('quantity_per_user') ? 'error' : ''; ?>">
            <?php echo $form->textFieldRow($model, 'quantity_per_user', array('class' => 'span2', 'data-original-title' => $model->getAttributeLabel('quantity_per_user'), 'data-content' => $model->getAttributeDescription('quantity_per_user'))); ?>
        </div>

        <br/><br/>

        <?php $this->widget(
            'bootstrap.widgets.TbButton', array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'label' => Yii::t('ShopModule.coupon', 'Сохранить и продолжить'),
            ));
        ?>

        <?php $this->widget(
            'bootstrap.widgets.TbButton', array(
                'buttonType' => 'submit',
                'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
                'label' => Yii::t('ShopModule.coupon', 'Сохранить и вернуться к списку'),
            ));
        ?>

        <?php $this->endWidget(); ?>
    </div>
    <div class="tab-pane panel-body" id="history">
        <?php
        if (!$model->isNewRecord)
        {
            $order = new Order('search');
            $order->unsetAttributes();
            $order->coupon_code = $model->code;
            $this->widget('yupe\widgets\CustomGridView', array(
                'id' => 'order-grid',
                'type' => 'condensed',
                'dataProvider' => $order->search(),
                'filter' => $order,
                'rowCssClassExpression' => '$data->paid == Order::PAID_STATUS_PAID ? "alert-success" : ""',
                'ajaxUrl' => Yii::app()->createUrl('/shop/orderBackend/index', array('Order[coupon_code]' => $model->code)),
                'columns' => array(
                    array(
                        'name' => 'id',
                        'htmlOptions' => array('width' => '90px'),
                        'type' => 'raw',
                        'value' => 'CHtml::link("Заказ №".$data->id, array("/shop/orderBackend/update", "id" => $data->id))',
                    ),
                    array(
                        'name' => 'name',
                        'type' => 'raw',
                        'value' => '$data->name . ($data->note ? "<br><div class=\"note\">$data->note</div>" : "")',
                        'htmlOptions' => array('width' => '400px'),
                    ),
                    'total_price',
                    array(
                        'name' => 'paid',
                        'value' => '$data->getPaidStatus()',
                        'filter' => $order->getPaidStatusList(),
                    ),
                    array(
                        'name' => 'date'
                    ),
                    array(
                        'name' => 'coupon_code',
                        'visible' => true,
                    ),
                    array(
                        'name' => 'status',
                        'type' => 'raw',
                        'value' => '$this->grid->returnBootstrapStatusHtml($data, "status", "Status", array("fire", "road", "ok", "trash"))',
                        'filter' => $order->getStatusList()
                    ),
                    array(
                        'class' => 'bootstrap.widgets.TbButtonColumn',
                    ),
                ),
            ));
        }
        ?>
    </div>
</div>