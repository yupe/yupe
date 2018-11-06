<?php
/**
 * Отображение для layouts/main:
 *
 * @category YupeLayout
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     https://yupe.ru
 **/
?>
<!DOCTYPE html>
<html lang="<?= Yii::app()->getLanguage(); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=  CHtml::encode(Yii::app()->name); ?> <?=  CHtml::encode($this->pageTitle); ?></title>
    <?php
    $mainAssets = Yii::app()->getAssetManager()->publish(
        Yii::getPathOfAlias('application.modules.yupe.views.assets')
    );
    Yii::app()->getClientScript()->registerCssFile($mainAssets . '/css/styles.css');
    Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/js/main.js');
    Yii::app()->getClientScript()->registerScriptFile($mainAssets . '/js/jquery.li-translit.js');
    if (($langs = $this->yupe->getLanguageSelectorArray()) != []) {
        Yii::app()->getClientScript()->registerCssFile($mainAssets . '/css/flags.css');
    }
    $path = Yii::app()->getAssetManager()->publish(
        Yii::getPathOfAlias('application.modules.user.views.assets') . '/css/moscow-city.jpg'
    );
    ?>
    <link rel="shortcut icon" href="<?=  $mainAssets; ?>/img/favicon.ico"/>

</head>



<body style='background-image: url("<?= $path;?>")'>
<div id="overall-wrap">
    <!-- mainmenu -->
    <?php $brandTitle = Yii::t('UserModule.user', 'Control panel'); ?>
    <?php
    $this->widget(
        'bootstrap.widgets.TbNavbar',
        [
            //'type' => 'inverse',
            'fluid'    => true,
            'collapse' => true,
            'fixed'    => 'top',
            'brand'    => CHtml::image(
                    Yii::app()->getModule('yupe')->getLogo(),
                    CHtml::encode(Yii::app()->name),
                    [
                        'height' => '38',
                        'title'  => CHtml::encode(Yii::app()->name),
                    ]
                ),
            'brandUrl' => CHtml::normalizeUrl(["/yupe/backend/index"]),
            'items'    => [
                [
                    'class'       => 'bootstrap.widgets.TbMenu',
                    'htmlOptions' => ['class' => 'pull-right'],
                    'type'        => 'navbar',
                    'encodeLabel' => false,
                    'items'       => array_merge(
                        [
                            [
                                'icon'  => 'fa fa-fw fa-question-circle',
                                'label' => Yii::t('YupeModule.yupe', 'Help'),
                                'url'   => CHtml::normalizeUrl(['/yupe/backend/help']),
                                'items' => [
                                    [
                                        'icon'        => 'fa fa-fw fa-globe',
                                        'label'       => Yii::t('YupeModule.yupe', 'Official site'),
                                        'url'         => 'https://yupe.ru?from=help',
                                        'linkOptions' => ['target' => '_blank'],
                                    ],
                                    [
                                        'icon'        => 'fa fa-fw fa-book',
                                        'label'       => Yii::t('YupeModule.yupe', 'Official docs'),
                                        'url'         => 'http://docs.yupe.ru/?from=help',
                                        'linkOptions' => ['target' => '_blank'],
                                    ],
                                    [
                                        'icon'        => 'fa fa-fw fa-th-large',
                                        'label'       => Yii::t('YupeModule.yupe', 'Additional modules'),
                                        'url'         => 'https://yupe.ru/store',
                                        'linkOptions' => ['target' => '_blank'],
                                    ],
                                    [
                                        'icon'        => 'fa fa-fw fa-comment',
                                        'label'       => Yii::t('YupeModule.yupe', 'Forum'),
                                        'url'         => 'http://talk.yupe.ru/?from=help',
                                        'linkOptions' => ['target' => '_blank'],
                                    ],
                                    [
                                        'icon'        => 'fa fa-fw fa-comment',
                                        'label'       => Yii::t('YupeModule.yupe', 'Chat'),
                                        'url'         => 'http://gitter.im/yupe/yupe',
                                        'linkOptions' => ['target' => '_blank'],
                                    ],
                                    [
                                        'icon'        => 'fa fa-fw fa-globe',
                                        'label'       => Yii::t('YupeModule.yupe', 'Community on github'),
                                        'url'         => 'https://github.com/yupe/yupe',
                                        'linkOptions' => ['target' => '_blank'],
                                    ],
                                    [
                                        'icon'        => 'fa fa-fw fa-thumbs-up',
                                        'label'       => Yii::t('YupeModule.yupe', 'Order development and support'),
                                        'url'         => 'https://yupe.ru/service?from=help-support',
                                        'linkOptions' => ['target' => '_blank'],
                                    ],
                                    [
                                        'icon'        => 'fa fa-fw fa-warning',
                                        'label'       => Yii::t('YupeModule.yupe', 'Report a bug'),
                                        'url'         => 'https://yupe.ru/contacts?from=help-support',
                                        'linkOptions' => ['target' => '_blank'],
                                    ],
                                    [
                                        'icon'        => 'fa fa-fw fa-question-circle',
                                        'label' => Yii::t('YupeModule.yupe', 'About Yupe!'),
                                        'url'   => 'https://yupe.ru/about?from=help-support',
                                    ],
                                ]
                            ],
                            [
                                'icon'    => 'fa fa-fw fa-home',
                                'label'   => Yii::t('YupeModule.yupe', 'Go home'),
                                'visible' => Yii::app()->getController(
                                    ) instanceof yupe\components\controllers\BackController === true,
                                'url'     => Yii::app()->createAbsoluteUrl('/')
                            ],
                        ],
                        $this->yupe->getLanguageSelectorArray()
                    ),
                ],
            ],
        ]
    ); ?>

    <div class="container-fluid" id="page">
        <div class="row">
            <?=  $content; ?>
        </div>
    </div>
    <div id="footer-guard"></div>
</div>

<footer>
    &copy; 2012 - <?=  date('Y'); ?>
    <?=  $this->yupe->poweredBy(); ?>
</footer>
</body>
</html>
