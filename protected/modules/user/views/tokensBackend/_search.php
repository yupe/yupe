<button class="btn btn-small dropdown-toggle" data-toggle="collapse" data-target="#search-toggle">
    <i class="icon-search">&nbsp;</i>
    <?php echo CHtml::link(Yii::t('UserModule.user', 'Find tokens'), '#', array('class' => 'search-button')); ?>
    <span class="caret">&nbsp;</span>
</button>

<div id="search-toggle" class="collapse out search-form">
    <?php Yii::app()->clientScript->registerScript('search', "
        $(document).on('submit', '.search-form form', function(event) {
            
            event.preventDefault();

            var form = $(this);

            $.fn.yiiGridView.update($('.grid-view').attr('id'), {
                data: form.serializeObject()
            });
        });
    "); ?>


    <?php $form = $this->beginWidget(
        'bootstrap.widgets.TbActiveForm', array(
            'action'      => Yii::app()->createUrl($this->route),
            'method'      => 'POST',
            'type'        => 'vertical',
            'htmlOptions' => array('class' => 'well'),
        )
    ); ?>
        <div class="row-fluid">
            <div class="form-controls span6">
                <?php echo $form->dropDownListRow(
                    $model, 'user_id', $model->getUserList(), array(
                        'empty' => '---', 'class' => 'span12'
                    )
                ); ?>
            </div>

            <div class="form-controls span6">
                <?php echo $form->dropDownListRow(
                    $model, 'status', $model->getStatusList(), array(
                        'empty' => '---', 'class' => 'span12'
                    )
                ); ?>
            </div>
        </div>

        <div class="row-fluid">
            <div class="form-controls span6">
                <?php echo $form->dropDownListRow(
                    $model, 'type', $model->getTypeList(), array(
                        'empty' => '---', 'class' => 'span12'
                    )
                ); ?>
            </div>

            <div class="form-controls span6">
                <?php echo $form->dropDownListRow(
                    $model, 'created', $model->getDateList(), array(
                        'empty' => '---', 'class' => 'span12'
                    )
                ); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php $this->widget(
                'bootstrap.widgets.TbButton', array(
                    'buttonType'  => 'submit',
                    'type'        => 'primary',
                    'icon'        => 'white search',
                    'label'       => Yii::t('UserModule.user', 'Find user'),
                )
            ); ?>

            <?php $this->widget(
                'bootstrap.widgets.TbButton', array(
                    'buttonType'  => 'reset',
                    'type'        => 'danger',
                    'icon'        => 'white remove',
                    'label'       => Yii::t('UserModule.user', 'Reset'),
                )
            ); ?>
        </div>
    <?php $this->endWidget(); ?>
</div>

<hr />