<?php
/**
 * Отображение для index:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
?>
<h1><?php echo Yii::t('InstallModule.install', 'Welcome!'); ?></h1>

<p><?php echo Yii::t(
        'InstallModule.install',
        '{app} can help to deploy YiiFramework project fast and easy.',
        ['{app}' => Yii::app()->name]
    ); ?></p>
<p><?php echo Yii::t('InstallModule.install', 'Please follow installation instructions.'); ?></p>

<div class="alert alert-block alert-warning">
    <p><?php echo Yii::t(
            'InstallModule.install',
            'We always happy to see you on our site {link}. We also have {twitter} and {forum}!',
            [
                '{twitter}' => CHtml::link('twitter', 'http://twitter.com/yupecms', ['target' => '_blank']),
                '{link}'    => CHtml::link(
                        'http://yupe.ru',
                        'http://yupe.ru?from=install',
                        ['target' => '_blank']
                    ),
                '{forum}'   => CHtml::link(
                        Yii::t('InstallModule.install', 'forum'),
                        'http://yupe.ru/talk?from=install',
                        ['target' => '_blank']
                    )
            ]
        ); ?>
    </p>

    <p><b><?php echo Yii::t(
                'InstallModule.install',
                'If you have a problem with install, please go to {link}',
                [
                    '{link}' => CHtml::link(
                            Yii::t('InstallModule.install', 'our forum'),
                            'http://yupe.ru/talk/viewforum.php?id=10',
                            ['target' => '_blank']
                        )
                ]
            );?></b></p>
</div>

<p><?php echo Yii::t('InstallModule.install', 'Please, select your language below for continue.'); ?>

<div class="btn-group">
    <?php $languages = $this->yupe->getLanguagesList(); ?>
    <?php foreach ($languages as $lang => $lang_label) : { ?>
        <?php $this->widget(
            'bootstrap.widgets.TbButton',
            [
                'icon'       => 'iconflags iconflags-' . $lang,
                'label'      => isset($lang_label) ? $lang_label : $lang,
                'buttonType' => 'link',
                'url'        => ['/install/default/environment', Yii::app()->getUrlManager()->langParam => $lang],
            ]
        ); ?>
    <?php } endforeach; ?>
</div>
