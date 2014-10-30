<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbCollapse'
);?>


<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#<?= $this->getId(); ?>">
                    <i class="fa fa-comment"></i> <?php echo Yii::t(
                        'CommentModule.comment',
                        'Comments'
                    ); ?>
                </a>
                <span class="badge alert-success"><?php echo $commentsCount; ?></span>
                <span class="badge alert-info"><?php echo $allCommentsCnt; ?></span>
                <span class="badge alert-danger"><?php echo $newCnt; ?></span>
            </h4>
        </div>


        <div id="<?= $this->getId(); ?>" class="panel-collapse collapse">
            <div class="panel-body">


                <div class="row">
                    <div class="col-sm-8">
                        <?php $this->widget(
                            'bootstrap.widgets.TbExtendedGridView',
                            array(
                                'id'           => 'post-grid',
                                'type'         => 'striped condensed',
                                'dataProvider' => $dataProvider,
                                'template'     => '{items}',
                                'htmlOptions'  => array(
                                    'class' => false
                                ),
                                'columns'      => array(
                                    array(
                                        'name'  => 'text',
                                        'value' => 'CHtml::link(yupe\helpers\YText::characterLimiter($data->text, 100), array("/comment/commentBackend/update","id" => $data->id))',
                                        'type'  => 'html'
                                    ),
                                    'creation_date',
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
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
