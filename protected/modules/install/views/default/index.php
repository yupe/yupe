<?php
/**
 * Отображение для index:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     https://yupe.ru
 **/
?>
<h1><?=  Yii::t('InstallModule.install', 'Welcome!'); ?></h1>

<p><?=  Yii::t(
        'InstallModule.install',
        '{app} can help to deploy your new store fast and easy.',
        ['{app}' => Yii::app()->name]
    ); ?></p>
<p><?=  Yii::t('InstallModule.install', 'Please follow installation instructions.'); ?></p>

<div class="alert alert-block alert-warning">
    <p><?=  Yii::t(
            'InstallModule.install',
            'We always happy to see you on our site {link}. We also have {twitter} and {forum}!',
            [
                '{twitter}' => CHtml::link('twitter', 'http://twitter.com/yupecms', ['target' => '_blank']),
                '{link}'    => CHtml::link(
                        'https://yupe.ru',
                        'https://yupe.ru?from=install',
                        ['target' => '_blank']
                    ),
                '{forum}'   => CHtml::link(
                        Yii::t('InstallModule.install', 'forum'),
                        'http://talk.yupe.ru/?from=install',
                        ['target' => '_blank']
                    )
            ]
        ); ?>
    </p>

    <p><b><?=  Yii::t(
                'InstallModule.install',
                'If you have a problem with install, please go to {link}',
                [
                    '{link}' => CHtml::link(
                            Yii::t('InstallModule.install', 'our forum'),
                            'http://talk.yupe.ru/',
                            ['target' => '_blank']
                        )
                ]
            );?></b></p>
</div>

<p><?=  Yii::t('InstallModule.install', 'Please, select your language below for continue.'); ?>

<div class="btn-group">
    <?php $languages = $this->yupe->getLanguagesList(); ?>
    <?php foreach ($languages as $lang => $label) : { ?>
        <?php $this->widget(
            'bootstrap.widgets.TbButton',
            [
                'icon'       => 'iconflags iconflags-' . $lang,
                'label'      => isset($label) ? $label : $lang,
                'buttonType' => 'link',
                'url'        => ['/install/default/environment', Yii::app()->getUrlManager()->langParam => $lang],
            ]
        ); ?>
    <?php } endforeach; ?>
</div>
