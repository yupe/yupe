<div class="alert alert-warning">
    <p><b><?= Yii::t(
                'InstallModule.install',
                'If you have problems with installation, please check {link} or {feedback}',
                [
                    '{link}' => CHtml::link(
                        Yii::t('InstallModule.install', 'our forum'),
                        'http://talk.yupe.ru/?from=install',
                        ['target' => '_blank']
                    ),
                    '{feedback}' => CHtml::link(
                        Yii::t('InstallModule.install', 'contact us'),
                        'https://yupe.ru/contacts?from=install',
                        ['target' => '_blank']
                    ),
                ]
            ); ?></b></p>
</div>
