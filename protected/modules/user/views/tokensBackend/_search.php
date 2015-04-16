<p>
    <a class="btn btn-default btn-sm" data-toggle="collapse" data-target="#search-toggle">
        <i class="fa fa-search">&nbsp;</i>
        <?php echo Yii::t('UserModule.user', 'Find tokens'); ?>
        <span class="caret">&nbsp;</span>
    </a>
</p>

<div id="search-toggle" class="collapse out search-form">
    <?php Yii::app()->clientScript->registerScript(
        'search',
        "
        $(document).on('submit', '.search-form form', function (event) {

            event.preventDefault();

            var form = $(this);

            $.fn.yiiGridView.update($('.grid-view').attr('id'), {
                data: form.serializeObject()
            });
        });
    "
    ); ?>

    <?php $form = $this->beginWidget(
        'bootstrap.widgets.TbActiveForm',
        [
            'action'      => Yii::app()->createUrl($this->route),
            'method'      => 'POST',
            'type'        => 'vertical',
            'htmlOptions' => ['class' => 'well'],
        ]
    ); ?>
    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->dropDownListGroup(
                $model,
                'user_id',
                [
                    'widgetOptions' => [
                        'data'        => $model->getUserList(),
                        'htmlOptions' => [
                            'empty' => '---',
                        ],
                    ],
                ]
            ); ?>
        </div>

        <div class="col-sm-6">
            <?php echo $form->dropDownListGroup(
                $model,
                'status',
                [
                    'widgetOptions' => [
                        'data'        => $model->getStatusList(),
                        'htmlOptions' => [
                            'empty' => '---',
                        ],
                    ],
                ]
            ); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?php echo $form->dropDownListGroup(
                $model,
                'type',
                [
                    'widgetOptions' => [
                        'data'        => $model->getTypeList(),
                        'htmlOptions' => [
                            'empty' => '---',
                        ],
                    ],
                ]
            ); ?>
        </div>

        <div class="col-sm-6">
            <?php echo $form->dropDownListGroup(
                $model,
                'create_time',
                [
                    'widgetOptions' => [
                        'data'        => $model->getDateList(),
                        'htmlOptions' => [
                            'empty' => '---',
                        ],
                    ],
                ]
            ); ?>
        </div>
    </div>

    <div class="form-actions">
        <?php $this->widget(
            'bootstrap.widgets.TbButton',
            [
                'buttonType' => 'submit',
                'context'    => 'primary',
                'icon'       => 'fa fa-search',
                'label'      => Yii::t('UserModule.user', 'Find tokens'),
            ]
        ); ?>

        <?php $this->widget(
            'bootstrap.widgets.TbButton',
            [
                'buttonType' => 'reset',
                'context'    => 'danger',
                'icon'       => 'fa fa-times',
                'label'      => Yii::t('UserModule.user', 'Reset'),
            ]
        ); ?>
    </div>
    <?php $this->endWidget(); ?>
</div>
