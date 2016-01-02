<?php
/**
 * Отображение для layouts/main:
 *
 * @category YupeLayout
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
?>
<!DOCTYPE html>
<html lang="<?= Yii::app()->getLanguage(); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo CHtml::encode(Yii::app()->name); ?> <?php echo CHtml::encode($this->pageTitle); ?></title>
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
    <link rel="shortcut icon" href="<?php echo $mainAssets; ?>/img/favicon.ico"/>

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
                                        'url'         => 'http://yupe.ru?from=help',
                                        'linkOptions' => ['target' => '_blank'],
                                    ],
                                    [
                                        'icon'        => 'fa fa-fw fa-globe',
                                        'label'       => Yii::t('YupeModule.yupe', 'Community'),
                                        'url'         => 'http://yupe.ru?from=help',
                                        'linkOptions' => ['target' => '_blank'],
                                    ],
                                    [
                                        'icon'        => 'fa fa-fw fa-book',
                                        'label'       => Yii::t('YupeModule.yupe', 'Official docs'),
                                        'url'         => 'http://yupe.ru/docs/index.html?from=help',
                                        'linkOptions' => ['target' => '_blank'],
                                    ],
                                    [
                                        'icon'        => 'fa fa-fw fa-th-large',
                                        'label'       => Yii::t('YupeModule.yupe', 'Additional modules'),
                                        'url'         => 'https://github.com/yupe/yupe-ext',
                                        'linkOptions' => ['target' => '_blank'],
                                    ],
                                    [
                                        'icon'        => 'fa fa-fw fa-comment',
                                        'label'       => Yii::t('YupeModule.yupe', 'Forum'),
                                        'url'         => 'http://yupe.ru/talk/?from=help',
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
                                        'url'         => 'http://yupe.ru/service?from=help-support',
                                        'linkOptions' => ['target' => '_blank'],
                                    ],
                                    [
                                        'icon'        => 'fa fa-fw fa-warning',
                                        'label'       => Yii::t('YupeModule.yupe', 'Report a bug'),
                                        'url'         => 'http://yupe.ru/contacts?from=help-support',
                                        'linkOptions' => ['target' => '_blank'],
                                    ],
                                    [
                                        'icon'        => 'fa fa-fw fa-question-circle',
                                        'label' => Yii::t('YupeModule.yupe', 'About Yupe!'),
                                        'url'   => 'http://yupe.ru/about?from=help-support',
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
            <?php echo $content; ?>
        </div>
    </div>
    <div id="footer-guard"></div>
</div>

<footer>
    &copy; 2012 - <?php echo date('Y'); ?>
    <?php echo $this->yupe->poweredBy(); ?>
</footer>
</body>
</html>
