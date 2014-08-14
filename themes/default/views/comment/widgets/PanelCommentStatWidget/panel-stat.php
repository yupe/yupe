<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbPanel',
    array(
        'title' => Yii::t('CommentModule.comment', 'Comments'),
        'headerIcon' => 'glyphicon glyphicon-comment'
    )
);?>
<div class="row">
    <div class="col-sm-8">
        <?php $this->widget(
            'bootstrap.widgets.TbExtendedGridView',
            array(
                'id' => 'post-grid',
                'type' => 'striped condensed',
                'dataProvider' => $dataProvider,
                'template' => '{items}',
                'htmlOptions' => array(
                    'class' => false
                ),
                'columns' => array(
                    array(
                        'name' => 'text',
                        'value' => 'CHtml::link(yupe\helpers\YText::characterLimiter($data->text, 100), array("/comment/commentBackend/update","id" => $data->id))',
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
    <div class="col-sm-4">
        <div class="row">
            <table>
                <tbody>
                    <tr>
                        <td>
                            <?php echo Yii::t('CommentModule.comment', 'Comments (last day / all)'); ?>:

                        </td>
                        <td>
                            <span class="badge alert-success"><?php echo $commentsCount; ?></span>
                            <span class="badge alert-info"><?php echo $allCommentsCnt; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo Yii::t('CommentModule.comment', 'Moderation'); ?>:
                        </td>
                        <td>
                            <span class="badge alert-danger"><?php echo $newCnt; ?></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
