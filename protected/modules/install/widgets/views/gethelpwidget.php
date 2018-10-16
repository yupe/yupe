<div class="alert alert-warning">
    <p><b><?php echo Yii::t(
                'InstallModule.install',
                'If you have problems with installation, please check {link} or {feedback}',
                [
                    '{link}'     => CHtml::link(
                            Yii::t('InstallModule.install', 'our forum'),
                            'http://yupe.ru/talk/viewforum.php?id=10',
                            ['target' => '_blank']
                        ),
                    '{feedback}' => CHtml::link(
                            Yii::t('InstallModule.install', 'contact us'),
                            'http://yupe.ru/contacts?from=install',
                            ['target' => '_blank']
                        ),
                ]
            );?></b></p>
</div>
