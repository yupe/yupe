<?php

Yii::app()->clientScript->registerCssFile(Yii::app()->getTheme()->getAssetsUrl() . "/css/user-popup-info.css");

Yii::app()->clientScript->registerScript(
    'popover-help',
    "$('.popover-help').popover({ trigger: 'hover', placement: 'bottom', delay: 500, html: true });",
    CClientScript::POS_END
);

?>

<span class="user-popup-info-widget">
	<?php echo CHtml::link(
        $model->nick_name,
        array(
            '/user/people/userInfo/',
            'username' => $model->nick_name
        ),
        array(
            'class'        => 'popover-help',
            'data-content' => str_replace(
                '"',
                "'",
                "<div class='user-popup-info'>"
                . CHtml::link(
                    $this->widget(
                        'application.modules.user.widgets.AvatarWidget',
                        array(
                            'user' => $model,
                            'size' => '40',
                        ),
                        true
                    ) . "<span>" . $model->getFullName() . "</span>",
                    array('/user/people/userInfo/', 'username' => $model->nick_name),
                    array('title' => Yii::t('UserModule.user', 'User profile'), 'class' => 'user-popup-info-block')
                )
                . '<span class="user-popup-info-link">'
                . CHtml::link($model->site, $model->site)
                . '</span>'
                . '</div>'
            ),
        )
    ); ?>
</span>
