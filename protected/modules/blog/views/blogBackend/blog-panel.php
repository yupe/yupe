<div class="row-fluid">

    <div class="span8">

        <?php $this->widget(
            'bootstrap.widgets.TbExtendedGridView', array(
                'id'           => 'post-grid',
                'type'         => 'striped condensed',
                'dataProvider' => $dataProvider,
                'template' => '{items}',
                'htmlOptions' => array(
                    'class' => false
                ),
                'columns' => array(
                    array(
                        'name'  => 'title',
                        'value' => 'CHtml::link($data->title, array("/blog/postBackend/update","id" => $data->id))',
                        'type'  => 'html'
                    ),
                    array(
                        'name'   => 'status',
                        'value'  => '$data->getStatus()',
                    ),
                ),
            )
        ); ?>

    </div>

    <div class="span4">
        <div class="row-fluid">

            <div class="span6">
                <div>
                    <?php echo Yii::t('BlogModule.blog', 'Posts (last day / all)'); ?>:
                </div>
                <br/>
                <div>
                    <?php echo Yii::t('BlogModule.blog', 'Comments (last day / all)'); ?>:
                </div>
                <br/>
                <div>
                    <?php echo Yii::t('BlogModule.blog', 'Users (last day / all)'); ?>:
                </div>
            </div>

            <div class="span6 pull-right">
                <div>
                    <span class="badge badge-success"><?php echo $postsCount; ?></span>
                    <span class="badge badge-info"><?php echo $allPostsCnt; ?></span>
                </div>
                <br/>
                <div>
                    <span class="badge badge-success"><?php echo $commentCount; ?></span>
                    <span class="badge badge-info"><?php echo $allCommentCnt; ?></span>
                </div>
                <br/>
                <div>
                    <span class="badge badge-success"><?php echo $usersCount; ?></span>
                    <span class="badge badge-info"><?php echo $allUsersCnt; ?></span>
                </div>
            </div>

        </div>

    </div>

</div>