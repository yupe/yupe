<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbCollapse', [
        'htmlOptions' => [
            'id' => 'panel-feedback-stat'
        ]
    ]
);?>


<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#<?= $this->getId(); ?>">
                    <i class="fa fa-retweet"></i> <?php echo Yii::t(
                        'FeedbackModule.feedback',
                        'Feedback'
                    ); ?>
                </a>
                <span class="badge alert-success"><?php echo $feedbackCount; ?></span>
                <span class="badge alert-info"><?php echo $allFeedbackCount; ?></span>
                <span class="badge alert-danger"><?php echo $needAnswerCount; ?></span>
            </h4>
        </div>

        <div id="<?= $this->getId(); ?>" class="panel-collapse collapse">
            <div class="panel-body">


                <div class="row">
                    <div class="col-sm-8">
                        <?php $this->widget(
                            'bootstrap.widgets.TbExtendedGridView',
                            [
                                'id' => 'feedback-grid',
                                'type' => 'striped condensed',
                                'dataProvider' => $dataProvider,
                                'template' => '{items}',
                                'htmlOptions' => [
                                    'class' => false
                                ],
                                'columns' => [
                                    [
                                        'name' => 'theme',
                                        'value' => 'CHtml::link($data->theme, array("/feedback/feedbackBackend/update","id" => $data->id))',
                                        'type' => 'html'
                                    ],
                                    'create_time',
                                    [
                                        'name' => 'status',
                                        'value' => '$data->getStatus()',
                                    ],
                                ],
                            ]
                        ); ?>
                    </div>
                    <div class="col-sm-4">
                        <div class="row">
                            <table>
                                <tbody>
                                <tr>
                                    <td>
                                        <?php echo Yii::t('FeedbackModule.feedback', 'Feedback (last day / all)'); ?>:
                                    </td>
                                    <td>
                                        <span class="badge alert-success"><?php echo $feedbackCount; ?></span>
                                        <span class="badge alert-info"><?php echo $allFeedbackCount; ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo Yii::t('FeedbackModule.feedback', 'Need answer'); ?>:
                                    </td>
                                    <td>
                                        <span class="badge alert-danger"><?php echo $needAnswerCount; ?></span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<?php $this->endWidget(); ?>
