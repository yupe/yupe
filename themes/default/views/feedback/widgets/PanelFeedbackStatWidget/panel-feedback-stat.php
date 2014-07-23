<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => Yii::t('FeedbackModule.feedback', 'Feedback'),
        'headerIcon' => 'icon-envelope'
    )
);?>

    <div class="row-fluid">

        <div class="span8">

            <?php $this->widget(
                'bootstrap.widgets.TbExtendedGridView',
                array(
                    'id' => 'feedback-grid',
                    'type' => 'striped condensed',
                    'dataProvider' => $dataProvider,
                    'template' => '{items}',
                    'htmlOptions' => array(
                        'class' => false
                    ),
                    'columns' => array(
                        array(
                            'name' => 'theme',
                            'value' => 'CHtml::link($data->theme, array("/feedback/feedbackBackend/update","id" => $data->id))',
                            'type' => 'html'
                        ),
                        array(
                            'name' => 'status',
                            'value' => '$data->getStatus()',
                        ),
                    ),
                )
            ); ?>

        </div>

        <div class="span4">
            <div class="row-fluid">

                <div class="span6">
                    <div>
                        <?php echo Yii::t('FeedbackModule.feedback', 'Feedback (last day / all)'); ?>:
                    </div>
                    <br/>

                    <div>
                        <?php echo Yii::t('FeedbackModule.feedback', 'Need answer'); ?>:
                    </div>
                </div>

                <div class="span6 pull-right">
                    <div>
                        <span class="badge badge-success"><?php echo $feedbackCount; ?></span>
                        <span class="badge badge-info"><?php echo $allFeedbackCount; ?></span>
                    </div>
                    <br/>

                    <div>
                        <span class="badge badge-important"><?php echo $needAnswerCount; ?></span>
                    </div>
                </div>

            </div>
        </div>

    </div>

<?php $this->endWidget(); ?>