<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbPanel',
    array(
        'title'      => Yii::t('FeedbackModule.feedback', 'Feedback'),
        'headerIcon' => 'glyphicon glyphicon-envelope'
    )
);?>
<div class="row">
    <div class="col-sm-8">
        <?php $this->widget(
            'bootstrap.widgets.TbExtendedGridView',
            array(
                'id'           => 'feedback-grid',
                'type'         => 'striped condensed',
                'dataProvider' => $dataProvider,
                'template'     => '{items}',
                'htmlOptions'  => array(
                    'class' => false
                ),
                'columns'      => array(
                    array(
                        'name'  => 'theme',
                        'value' => 'CHtml::link($data->theme, array("/feedback/feedbackBackend/update","id" => $data->id))',
                        'type'  => 'html'
                    ),
                    array(
                        'name'  => 'status',
                        'value' => '$data->getStatus()',
                    ),
                ),
            )
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

<?php $this->endWidget(); ?>
