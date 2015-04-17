<ul class="nav nav-tabs">
    <li class="active"><a href="#coupon" data-toggle="tab"><?php echo Yii::t("CouponModule.coupon", "Coupon"); ?></a></li>
    <?php if(!$model->getIsNewRecord()):?>
        <li><a href="#history" data-toggle="tab"><?php echo Yii::t("CouponModule.coupon", "Purchasing history"); ?></a></li>
    <?php endif;?>
</ul>

<div class="tab-content">
    <div class="tab-pane active" id="coupon">
        <?php
        /* @var $model Coupon */
        $form = $this->beginWidget(
            'bootstrap.widgets.TbActiveForm',
            [
                'id' => 'coupon-form',
                'enableAjaxValidation' => false,
                'enableClientValidation' => true,
                'htmlOptions' => ['class' => 'well'],
            ]
        );
        ?>
        <div class="alert alert-info">
            <?php echo Yii::t('CouponModule.coupon', 'Fields with'); ?>
            <span class="required">*</span>
            <?php echo Yii::t('CouponModule.coupon', 'are required'); ?>
        </div>

        <?php echo $form->errorSummary($model); ?>
        <div class="row">
            <div class="col-sm-3">
                <?php echo $form->dropDownListGroup(
                    $model,
                    'type',
                    [
                        'widgetOptions' => [
                            'data' => $model->getTypeList(),
                        ],
                    ]
                ); ?>
            </div>
            <div class="col-sm-3">
                <?php echo $form->dropDownListGroup(
                    $model,
                    'status',
                    [
                        'widgetOptions' => [
                            'data' => $model->getStatusList(),
                        ],
                    ]
                ); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-7">
                <?php echo $form->textFieldGroup($model, 'name'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-7">
                <?php echo $form->textFieldGroup($model, 'code'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <?php echo $form->textFieldGroup($model, 'value'); ?>
            </div>
            <div class="col-sm-4">
                <?php echo $form->textFieldGroup($model, 'min_order_price'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <?php echo $form->dropDownListGroup(
                    $model,
                    'free_shipping',
                    [
                        'widgetOptions' => [
                            'data' => $this->module->getChoice(),
                        ],
                    ]
                ); ?>
            </div>
            <div class="col-sm-4">
                <?php echo $form->dropDownListGroup(
                    $model,
                    'registered_user',
                    [
                        'widgetOptions' => [
                            'data' => $this->module->getChoice(),
                        ],
                    ]
                ); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-4">
                <?php echo $form->datePickerGroup(
                    $model,
                    'start_time',
                    [
                        'widgetOptions' => [
                            'options' => [
                                'format' => 'yyyy-mm-dd',
                                'weekStart' => 1,
                                'autoclose' => true,
                            ],
                        ],
                        'prepend' => '<i class="fa fa-calendar"></i>',
                    ]
                );
                ?>
            </div>
            <div class="col-sm-3">
                <?php echo $form->datePickerGroup(
                    $model,
                    'end_time',
                    [
                        'widgetOptions' => [
                            'options' => [
                                'format' => 'yyyy-mm-dd',
                                'weekStart' => 1,
                                'autoclose' => true,
                            ],
                        ],
                        'prepend' => '<i class="fa fa-calendar"></i>',
                    ]
                );
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <?php echo $form->textFieldGroup($model, 'quantity'); ?>
            </div>
            <div class="col-sm-3">
                <?php echo $form->textFieldGroup($model, 'quantity_per_user'); ?>
            </div>
        </div>


        <?php $this->widget(
            'bootstrap.widgets.TbButton',
            [
                'buttonType' => 'submit',
                'context' => 'primary',
                'label' => $model->getIsNewRecord() ? Yii::t('CouponModule.coupon', 'Add coupon and continue') : Yii::t('CouponModule.coupon', 'Save coupon and continue'),
            ]
        ); ?>

        <?php $this->widget(
            'bootstrap.widgets.TbButton',
            [
                'buttonType' => 'submit',
                'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
                'label' => $model->getIsNewRecord() ? Yii::t('CouponModule.coupon', 'Add coupon and close') : Yii::t('CouponModule.coupon', 'Save coupon and close'),
            ]
        ); ?>

        <?php $this->endWidget(); ?>
    </div>

    <?php  if (!$model->getIsNewRecord()):?>
    <div class="tab-pane panel-body" id="history">

        <?php
            Yii::app()->getModule('order');
            $order = new Order('search');
            $order->unsetAttributes();
            $this->widget(
                'yupe\widgets\CustomGridView',
                [
                    'id' => 'order-grid',
                    'type' => 'condensed',
                    'dataProvider' => $order->search($model->id),
                    'filter' => $order,
                    'rowCssClassExpression' => '$data->paid == Order::PAID_STATUS_PAID ? "alert-success" : ""',
                    'ajaxUrl' => Yii::app()->createUrl('/order/orderBackend/index'),
                    'actionsButtons' => false,
                    'bulkActions' => [false],
                    'columns' => [
                        [
                            'name' => 'id',
                            'htmlOptions' => ['width' => '90px'],
                            'type' => 'raw',
                            'value' => 'CHtml::link(Yii::t("CouponModule.coupon", "Order #").$data->id, array("/order/orderBackend/update", "id" => $data->id))',
                        ],
                        [
                            'name' => 'name',
                            'type' => 'raw',
                            'value' => '$data->name . ($data->note ? "<br><div class=\"note\">$data->note</div>" : "")',
                            'htmlOptions' => ['width' => '400px'],
                        ],
                        'total_price',
                        [
                            'name' => 'paid',
                            'value' => '$data->getPaidStatus()',
                            'filter' => $order->getPaidStatusList(),
                        ],
                        [
                            'name' => 'date'
                        ],
                        [
                            'name'  => 'status',
                            'type'  => 'raw',
                            'value' => function($data) {
                                  return $data->status->getTitle();
                                },
                            'filter' => OrderStatus::model()->getList()
                        ],
                    ],
                ]
            );
        ?>
    </div>
    <?php endif;?>
</div>
