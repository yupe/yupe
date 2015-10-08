<?php

Yii::app()->clientScript->registerCssFile(Yii::app()->getTheme()->getAssetsUrl() . "/css/user-popup-info.css");

Yii::app()->clientScript->registerScript(
    'popover-help',
    "$('.popover-help').popover({ trigger: 'hover', placement: 'bottom', delay: 500, html: true });",
    CClientScript::POS_END
);

?>

<span class="user-popup-info-widget">
	<?= CHtml::link(
        $model->nick_name,
        [
            '/user/people/userInfo/',
            'username' => $model->nick_name
        ],
        [
            'class'        => 'popover-help',
            'data-content' => str_replace(
                '"',
                "'",
                "<div class='user-popup-info'>"
                . CHtml::link(
                    $this->widget(
                        'application.modules.user.widgets.AvatarWidget',
                        [
                            'user' => $model,
                            'size' => '40',
                            'imageHtmlOptions' => ['width' => 40, 'height' => 40]
                        ],
                        true
                    ) . "<span>" . $model->getFullName() . "</span>",
                    ['/user/people/userInfo/', 'username' => $model->nick_name],
                    ['title' => Yii::t('UserModule.user', 'User profile'), 'class' => 'user-popup-info-block']
                )
                . '<span class="user-popup-info-link">'
                . CHtml::link($model->site, $model->site)
                . '</span>'
                . '</div>'
            ),
        ]
    ); ?>
</span>
