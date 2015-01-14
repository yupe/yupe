<legend>
    <?php
    echo Yii::t(
        'YupeModule.yupe',
        'Migrations was founded for module "{moduleID}"',
        [
            '{moduleID}' => ucfirst($module->getId()),
        ]
    );?> :
</legend>
<?php
$newUpdates = [];
if (isset($updates[$module->getId()]) && ($updates = $updates[$module->getId()])) {
    foreach ($updates as $u) {
        $newUpdates[] = [
            'id'       => count($newUpdates) + 1,
            'fileName' => $u,
        ];
    }
}
?>
<div class='row'>
    <div class='container'>
        <div class='col-xs-5'>
            <?php
            $gridDataProvider = new CArrayDataProvider($newUpdates);
            $this->widget(
                'bootstrap.widgets.TbGridView',
                [
                    'template'     => '{items}{pager}',
                    'dataProvider' => $gridDataProvider,
                    'columns'      => [
                        [
                            'name'   => 'id',
                            'header' => 'ID',
                        ],
                        [
                            'name'   => 'fileName',
                            'header' => Yii::t('YupeModule.yupe', 'File'),
                        ],
                    ],
                ]
            );?>
            <?php
            $form = $this->beginWidget(
                'bootstrap.widgets.TbActiveForm',
                [
                    'id'     => 'moduleUpdateForm',
                    'type'   => 'vertical',
                    'action' => '#',
                ]
            );
            $this->widget(
                'bootstrap.widgets.TbButton',
                [
                    'buttonType' => 'submit',
                    'label'      => Yii::t('YupeModule.yupe', 'Refresh'),
                ]
            );
            $this->endWidget();
            ?>
        </div>
    </div>
</div>
