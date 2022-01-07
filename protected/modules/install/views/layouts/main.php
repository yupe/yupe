<?php
/**
 * Шаблон инсталятора:
 *
 * @category YupeLayouts
 * @package  yupe
 * @author   Yupe Team <support@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     https://yupe.ru
 **/
?>
<!DOCTYPE html>
<html lang="<?= Yii::app()->language;?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?=  CHtml::encode(Yii::app()->name) . ' ' . CHtml::encode($this->pageTitle); ?>
    </title>
    <?php
    Yii::app()->getClientScript()->registerCoreScript('jquery');
    $yupeAssets = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.modules.yupe.views.assets'));
    $installAssets = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.modules.install.views.assets'));
    Yii::app()->getClientScript()->registerCssFile($yupeAssets . '/css/styles.css');
    Yii::app()->getClientScript()->registerCssFile($yupeAssets . '/css/flags.css');
    Yii::app()->getClientScript()->registerCssFile($installAssets . '/css/install.css');
    ?>
    <link rel="shortcut icon" href="<?=  $yupeAssets . '/img/favicon.ico'; ?>">
</head>
<body>
<div id="overall-wrap">
    <?php
    $brandTitle = Yii::t('InstallModule.install', 'Install') . ' ' . CHtml::encode(Yii::app()->name);
    $this->widget(
        'bootstrap.widgets.TbNavbar',
        [
            'fluid'    => true,
            'brand'    => CHtml::image(
                $yupeAssets . "/img/logo.png",
                $brandTitle,
                [
                    'width'  => '38',
                    'height' => '38',
                    'title'  => $brandTitle,
                ]
            ),
            'brandUrl' => $this->createUrl('index'),
            'items'    => [
                CHtml::tag('span', ['id' => 'stepName'], CHtml::encode($this->stepName)),
                [
                    'class'       => 'bootstrap.widgets.TbMenu',
                    'type'        => 'navbar',
                    'htmlOptions' => ['class' => 'navbar-right'],
                    'items'       => array_merge(
                        [
                            [
                                'icon'        => 'fa fa-fw fa-info-circle',
                                'label'       => Yii::t('InstallModule.install', 'Support'),
                                'url'         => 'https://yupe.ru/service/support',
                                'linkOptions' => ['target' => '_blank'],
                            ],
                            [
                                'icon'        => 'fa fa-fw fa-book',
                                'label'       => Yii::t('YupeModule.yupe', 'Docs'),
                                'url'         => 'https://docs.yupe.ru?from=install',
                                'linkOptions' => ['target' => '_blank'],
                            ],
                            [
                                'icon'        => 'fa fa-fw fa-rss',
                                'label'       => Yii::t('InstallModule.install', 'Blog'),
                                'url'         => 'https://yupe.ru/posts?from=install',
                                'linkOptions' => ['target' => '_blank'],
                            ],
                            [
                                'icon'        => 'fa fa-fw fa-database',
                                'label'       => Yii::t('InstallModule.install', 'Hosting'),
                                'url'         => 'https://yupe.ru/service/hosting?from=install',
                                'linkOptions' => ['target' => '_blank'],
                            ],
                            [
                                'label' => $this->yupe->getVersion(),
                                'icon'  => 'fa fa-fw fa-thumbs-up',
                                'url'   => 'https://yupe.ru/download?from=install',
                                'linkOptions' => ['target' => '_blank'],
                            ],
                        ],
                        $this->yupe->getLanguageSelectorArray()
                    ),
                ],
            ],
        ]
    );
    ?>

    <div class='installContentWrapper'>
        <div class="installContent row">
            <?=  $content; ?>
        </div>
        <!-- content -->
    </div>
</div>
<footer>
    Copyright &copy; 2012-<?=  date('Y'); ?>
    <?=  $this->yupe->poweredBy(); ?>
    <small class="label label-info"><?=  $this->yupe->getVersion(); ?></small>
    <br/>
    <a href="https://yupe.ru/?from=install" target="_blank">
        <?=  Yii::t('YupeModule.yupe', 'Development and support'); ?></a> - <a
        href="https://yupe.ru/?from=install" target="_blank">yupe.ru</a>
    <br/>
    <?=  Yii::powered(); ?>
</footer>
<!-- footer -->
</body>
</html>
