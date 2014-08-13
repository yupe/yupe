<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbPanel',
    array(
        'title' => Yii::t('UserModule.user', 'Users'),
        'headerIcon' => 'glyphicon glyphicon-user'
    )
);?>
<div class="row">
    <div class="col-sm-8">
        <?php $this->widget(
            'bootstrap.widgets.TbExtendedGridView',
            array(
                'id' => 'user-grid',
                'type' => 'striped condensed',
                'dataProvider' => $dataProvider,
                'template' => '{items}',
                'htmlOptions' => array(
                    'class' => false
                ),
                'columns' => array(
                    array(
                        'name' => 'nick_name',
                        'value' => 'CHtml::link($data->getFullName(), array("/user/userBackend/update","id" => $data->id))',
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
                            <?php echo Yii::t('UserModule.user', 'Users (last day / all)'); ?>:

                        </td>
                        <td>
                            <span class="badge alert-success"><?php echo $usersCount; ?></span>
                            <span class="badge alert-info"><?php echo $allUsersCnt; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo Yii::t('UserModule.user', 'Not active'); ?>:
                        </td>
                        <td>
                            <span class="badge alert-danger"><?php echo $registeredCnt; ?></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
