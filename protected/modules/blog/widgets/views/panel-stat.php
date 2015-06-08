<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbCollapse', [
        'htmlOptions' => [
            'id' => 'panel-blog-stat'
        ]
    ]
);?>


<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#<?= $this->getId(); ?>">
                    <i class="fa fa-fw fa-pencil"></i> <?php echo Yii::t('BlogModule.blog', 'Blogs'); ?>
                </a>
                <span class="badge alert-success"><?php echo $postsCount; ?></span>
                <span class="badge alert-info"><?php echo $allPostsCnt; ?></span>
                <span class="badge alert-danger"><?php echo $moderationCnt; ?></span>
            </h4>
        </div>


        <div id="<?= $this->getId(); ?>" class="panel-collapse collapse">
            <div class="panel-body">

                <div class="row">
                    <div class="col-sm-2">
                        <?php echo CHtml::link(
                            Yii::t('BlogModule.blog', 'New post'),
                            ['/blog/postBackend/create'],
                            ['class' => 'btn btn-success btn-sm']
                        ); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-8">
                        <?php $this->widget(
                            'bootstrap.widgets.TbExtendedGridView',
                            [
                                'id'           => 'post-grid',
                                'type'         => 'striped condensed',
                                'dataProvider' => $dataProvider,
                                'template'     => '{items}',
                                'htmlOptions'  => [
                                    'class' => false
                                ],
                                'columns'      => [
                                    [
                                        'name'  => 'title',
                                        'value' => 'CHtml::link($data->title, array("/blog/postBackend/update","id" => $data->id))',
                                        'type'  => 'html'
                                    ],
                                    [
                                        'name'   => 'create_time',
                                        'value'  => 'Yii::app()->getDateFormatter()->formatDateTime($data->create_time, "short", "short")',
                                        'filter' => false
                                    ],
                                    [
                                        'name'  => 'status',
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
                                        <?php echo Yii::t('BlogModule.blog', 'Posts (last day / all)'); ?>:

                                    </td>
                                    <td>
                                        <span class="badge alert-success"><?php echo $postsCount; ?></span>
                                        <span class="badge alert-info"><?php echo $allPostsCnt; ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo Yii::t('BlogModule.blog', 'Moderation'); ?>:
                                    </td>
                                    <td>
                                        <span class="badge alert-danger"><?php echo $moderationCnt; ?></span>
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
