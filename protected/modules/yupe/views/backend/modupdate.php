<?php ?>
<legend>
    <?php
    echo Yii::t(
        'YupeModule.yupe', 'Найдены следующие миграции для модуля "{moduleID}"',
        array(
            '{moduleID}' => ucfirst($module->getId()),
        )
    );?> :
</legend>
<?php
$newUpdates = array();
if (isset($updates[$module->getId()]) && ($updates=$updates[$module->getId()])) {
    foreach ($updates as $u) {
        $newUpdates[] = array(
            'id'       => count($newUpdates) + 1,
            'fileName' => $u,
        );
    }
}
?>
<div class='row-fluid'>
    <div class='container'>
        <div class='span5'>
        <?php
        $gridDataProvider = new CArrayDataProvider($newUpdates);
        $this->widget(
            'bootstrap.widgets.TbGridView', array(
                'template'     => '{items}{pager}',
                'dataProvider' => $gridDataProvider,
                'columns'      =>array(
                    array(
                        'name'   => 'id',
                        'header' => 'ID',
                    ),
                    array(
                        'name'   => 'fileName',
                        'header' => Yii::t('YupeModule.yupe', 'Файл'),
                    ),
                ),
            )
        );?>
        <?php
        $form = $this->beginWidget(
            'bootstrap.widgets.TbActiveForm', array(
                'id'                     => 'moduleUpdateForm',
                'type'                   => 'vertical',
                'action'                 => '#',
            )
        );
            $this->widget(
                'bootstrap.widgets.TbButton', array(
                    'buttonType' => 'submit',
                    'label'      => Yii::t('YupeModule.yupe', 'Обновить'),
                )
            );
        $this->endWidget();
        //<form action="#" method="post"><input type="submit" value="<?php echo Yii::t('YupeModule.yupe','Обновить');? >"></form>
        ?>
        </div>
    </div>
</div>