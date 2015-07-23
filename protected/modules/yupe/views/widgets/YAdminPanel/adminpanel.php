<?php
/**
 * Отображение для виджета YAdminPanel:
 *
 * @category YupeView
 * @package  yupe
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://yupe.ru
 *
 **/
$mainAssets = Yii::app()->getAssetManager()->publish(
    Yii::getPathOfAlias('application.modules.yupe.views.assets')
);

foreach ($modules as &$item) {
    $item['linkOptions'] = ['title' => $item['label']];
    $item['label'] = CHtml::tag('span', ['class' => 'hidden-sm'], $item['label']);
}

$this->widget(
    'bootstrap.widgets.TbNavbar',
    [
        'fluid'    => true,
        'fixed'    => 'top',
        'brand'    => CHtml::image(
            $mainAssets . '/img/logo.png',
            CHtml::encode(Yii::app()->name),
            [
                'width'  => '38',
                'height' => '38',
                'title'  => CHtml::encode(Yii::app()->name),
            ]
        ),
        'brandUrl' => CHtml::normalizeUrl(["/yupe/backend/index"]),
        'items'    => [
            [
                'class' => 'bootstrap.widgets.TbMenu',
                'type'  => 'navbar',
                'encodeLabel' => false,
                'items' => $modules
            ],
            [
                'class'       => 'bootstrap.widgets.TbMenu',
                'htmlOptions' => ['class' => 'navbar-right visible-xs hidden-sm hidden-md visible-lg'],
                'type'        => 'navbar',
                'encodeLabel' => false,
                'items'       => array_merge(
                    [
                        [
                            'icon' => 'fa fa-fw fa-question-circle',
                            'label' => CHtml::tag(
                                    'span',
                                    ['class' => 'hidden-sm hidden-md hidden-lg'],
                                    Yii::t('YupeModule.yupe', 'Help')
                                ),
                            'url' => CHtml::normalizeUrl(['/yupe/backend/help']),
                            'items' => [
                                [
                                    'icon' => 'fa fa-fw fa-globe',
                                    'label' => Yii::t('YupeModule.yupe', 'Official site'),
                                    'url' => 'http://yupe.ru?from=help',
                                    'linkOptions' => ['target' => '_blank'],
                                ],
                                [
                                    'icon' => 'fa fa-fw fa-book',
                                    'label' => Yii::t('YupeModule.yupe', 'Official docs'),
                                    'url' => 'http://yupe.ru/docs/index.html?from=help',
                                    'linkOptions' => ['target' => '_blank'],
                                ],
                                [
                                    'icon' => 'fa fa-fw fa-th-large',
                                    'label' => Yii::t('YupeModule.yupe', 'Additional modules'),
                                    'url' => 'https://github.com/yupe/yupe-ext',
                                    'linkOptions' => ['target' => '_blank'],
                                ],
                                [
                                    'icon' => 'fa fa-fw fa-comment',
                                    'label' => Yii::t('YupeModule.yupe', 'Forum'),
                                    'url' => 'http://yupe.ru/talk/?from=help',
                                    'linkOptions' => ['target' => '_blank'],
                                ],
                                [
                                    'icon' => 'fa fa-fw fa-comment',
                                    'label' => Yii::t('YupeModule.yupe', 'Chat'),
                                    'url' => 'http://gitter.im/yupe/yupe',
                                    'linkOptions' => ['target' => '_blank'],
                                ],
                                [
                                    'icon' => 'fa fa-fw fa-globe',
                                    'label' => Yii::t('YupeModule.yupe', 'Community on github'),
                                    'url' => 'https://github.com/yupe/yupe',
                                    'linkOptions' => ['target' => '_blank'],
                                ],
                                [
                                    'icon' => 'fa fa-fw fa-thumbs-up',
                                    'label' => Yii::t('YupeModule.yupe', 'Order development and support'),
                                    'url' => 'http://amylabs.ru/contact?from=help-support',
                                    'linkOptions' => ['target' => '_blank'],
                                ],
                                [
                                    'icon' => 'fa fa-fw fa-warning',
                                    'label' => Yii::t('YupeModule.yupe', 'Report a bug'),
                                    'url' => 'http://yupe.ru/contacts?from=panel',
                                    'linkOptions' => ['target' => '_blank'],
                                ],
                                [
                                    'icon' => 'fa fa-fw fa-question-circle',
                                    'label' => Yii::t('YupeModule.yupe', 'About Yupe!'),
                                    'url' => ['/yupe/backend/help'],
                                ],
                            ]
                        ],
                        [
                            'icon' => 'fa fa-fw fa-home',
                            'label' => CHtml::tag(
                                    'span',
                                    ['class' => 'hidden-sm hidden-md hidden-lg'],
                                    Yii::t('YupeModule.yupe', 'Go home')
                                ),
                            'url' => Yii::app()->createAbsoluteUrl('/')
                        ],
                        [
                            'icon' => 'fa fa-fw fa-user',
                            'label' => '<span class="label label-info">' . CHtml::encode(
                                    Yii::app()->getUser()->getProfileField('fullName')
                                ) . '</span>',
                            'items' => [
                                [
                                    'icon' => 'fa fa-fw fa-cog',
                                    'label' => Yii::t('YupeModule.yupe', 'Profile'),
                                    'url' => CHtml::normalizeUrl(
                                            (['/user/userBackend/update', 'id' => Yii::app()->getUser()->getId()])
                                        ),
                                ],
                                [
                                    'icon' => 'fa fa-fw fa-power-off',
                                    'label' => Yii::t('YupeModule.yupe', 'Exit'),
                                    'url' => CHtml::normalizeUrl(['/user/account/logout']),
                                ],
                            ],
                        ],
                    ],
                    $this->getController()->yupe->getLanguageSelectorArray()
                ),
            ],
        ],
    ]
);?>

<script type="text/javascript">
    $(document).ready(function () {
        var url = window.location.href;
        $('.navbar .nav li').removeClass('active');
        $('.nav a').filter(function () {
            return this.getAttribute("href") != '#' && this.href == url;
        }).parents('li').addClass('active');
    });
</script>
