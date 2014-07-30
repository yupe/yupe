<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbPanel',
    array(
        'title' => Yii::t('BlogModule.blog', 'Blogs'),
        'headerIcon' => 'glyphicon glyphicon-pencil'
    )
);?>
<div class="row">
    <div class="col-sm-2">
        <?php echo CHtml::link(Yii::t('BlogModule.blog', 'New post'), array('/blog/postBackend/create'), array('class' => 'btn btn-success btn-sm')); ?>
    </div>
</div>
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
                        'name' => 'title',
                        'value' => 'CHtml::link($data->title, array("/blog/postBackend/update","id" => $data->id))',
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
                            <?php echo Yii::t('BlogModule.blog', 'Posts (last day / all)'); ?>:

                        </td>
                        <td>
                            <span class="badge alert-success"><?php echo $postsCount; ?></span>
                            <span class="badge alert-info"><?php echo $allPostsCnt; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo Yii::t('BlogModule.blog', 'Comments (last day / all)'); ?>:
                        </td>
                        <td>
                            <span class="badge alert-success"><?php echo $commentCount; ?></span>
                            <span class="badge alert-info"><?php echo $allCommentCnt; ?></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
