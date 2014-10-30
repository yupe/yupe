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
$this->widget(
    'bootstrap.widgets.TbNavbar',
    array(
        //'type' => 'inverse',
        'fluid'    => true,
        'collapse' => true,
        'fixed'    => 'top',
        'brand'    => CHtml::image(
            $mainAssets . '/img/logo.png',
            CHtml::encode(Yii::app()->name),
            array(
                'width'  => '38',
                'height' => '38',
                'title'  => CHtml::encode(Yii::app()->name),
            )
        ),
        'brandUrl' => CHtml::normalizeUrl(array("/yupe/backend/index")),
        'items'    => array(
            array(
                'class' => 'bootstrap.widgets.TbMenu',
                'type'  => 'navbar',
                'items' => $modules
            ),
            array(
                'class'       => 'bootstrap.widgets.TbMenu',
                'htmlOptions' => array('class' => 'navbar-right'),
                'type'        => 'navbar',
                'encodeLabel' => false,
                'items'       => array_merge(
                    array(
                        array(
                            'icon'  => 'fa fa-fw fa-question-circle',
                            'label' => Yii::t('YupeModule.yupe', 'Help'),
                            'url'   => CHtml::normalizeUrl(array('/yupe/backend/help')),
                            'items' => array(
                                array(
                                    'icon'        => 'fa fa-fw fa-globe',
                                    'label'       => Yii::t('YupeModule.yupe', 'Official site'),
                                    'url'         => 'http://yupe.ru?from=help',
                                    'linkOptions' => array('target' => '_blank'),
                                ),
                                array(
                                    'icon'        => 'fa fa-fw fa-book',
                                    'label'       => Yii::t('YupeModule.yupe', 'Official docs'),
                                    'url'         => 'http://yupe.ru/docs/index.html?from=help',
                                    'linkOptions' => array('target' => '_blank'),
                                ),
                                array(
                                    'icon'        => 'fa fa-fw fa-th-large',
                                    'label'       => Yii::t('YupeModule.yupe', 'Additional modules'),
                                    'url'         => 'https://github.com/yupe/yupe-ext',
                                    'linkOptions' => array('target' => '_blank'),
                                ),
                                array(
                                    'icon'        => 'fa fa-fw fa-comment',
                                    'label'       => Yii::t('YupeModule.yupe', 'Forum'),
                                    'url'         => 'http://yupe.ru/talk/?from=help',
                                    'linkOptions' => array('target' => '_blank'),
                                ),
                                array(
                                    'icon'        => 'fa fa-fw fa-comment',
                                    'label'       => Yii::t('YupeModule.yupe', 'Chat'),
                                    'url'         => 'http://gitter.im/yupe/yupe',
                                    'linkOptions' => array('target' => '_blank'),
                                ),
                                array(
                                    'icon'        => 'fa fa-fw fa-globe',
                                    'label'       => Yii::t('YupeModule.yupe', 'Community on github'),
                                    'url'         => 'https://github.com/yupe/yupe',
                                    'linkOptions' => array('target' => '_blank'),
                                ),
                                array(
                                    'icon'        => 'fa fa-fw fa-thumbs-up',
                                    'label'       => Yii::t('YupeModule.yupe', 'Order development and support'),
                                    'url'         => 'http://amylabs.ru/contact?from=help-support',
                                    'linkOptions' => array('target' => '_blank'),
                                ),
                                array(
                                    'icon'        => 'fa fa-fw fa-warning',
                                    'label'       => Yii::t('YupeModule.yupe', 'Report a bug'),
                                    'url'         => 'http://yupe.ru/contacts?from=panel',
                                    'linkOptions' => array('target' => '_blank'),
                                ),
                                array(
                                    'icon'  => 'fa fa-fw fa-question-circle',
                                    'label' => Yii::t('YupeModule.yupe', 'About Yupe!'),
                                    'url'   => array('/yupe/backend/help'),
                                ),
                            )
                        ),
                        array(
                            'icon'  => 'fa fa-fw fa-home',
                            'label' => Yii::t('YupeModule.yupe', 'Go home'),
                            'url'   => Yii::app()->createAbsoluteUrl('/')
                        ),
                        array(
                            'icon'  => 'fa fa-fw fa-user',
                            'label' => '<span class="label label-info">' . CHtml::encode(
                                    Yii::app()->getUser()->getProfileField('fullName')
                                ) . '</span>',
                            'items' => array(
                                array(
                                    'icon'  => 'fa fa-fw fa-cog',
                                    'label' => Yii::t('YupeModule.yupe', 'Profile'),
                                    'url'   => CHtml::normalizeUrl(
                                        (array('/user/userBackend/update', 'id' => Yii::app()->getUser()->getId()))
                                    ),
                                ),
                                array(
                                    'icon'  => 'fa fa-fw fa-power-off',
                                    'label' => Yii::t('YupeModule.yupe', 'Exit'),
                                    'url'   => CHtml::normalizeUrl(array('/user/account/logout')),
                                ),
                            ),
                        ),
                    ),
                    $yupe->getLanguageSelectorArray()
                ),
            ),
        ),
    )
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
