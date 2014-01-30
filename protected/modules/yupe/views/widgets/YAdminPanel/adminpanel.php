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

/**
 * Добавляем нужные CSS и JS:
 */

$this->widget(
    'bootstrap.widgets.TbNavbar', array(
        'htmlOptions' => array('class' => 'navbar navbar-fixed-top'),
        'fluid'       => true,
        'collapse'    => true,
        'brand'       => CHtml::image(
            Yii::app()->baseUrl . "/web/images/logo.png", Yii::app()->name, array(
                'width'  => '38',
                'height' => '38',
                'title'  => Yii::app()->name,
            )
        ),
        'brandUrl'    => CHtml::normalizeUrl(array("/yupe/backend/index")),
        'items'       => array(
            array(
                'class' => 'bootstrap.widgets.TbMenu',
                'items' => Yii::app()->moduleManager->getModules(true),
            ),
            array(
                'class'       => 'bootstrap.widgets.TbMenu',
                'htmlOptions' => array('class' => 'pull-right'),
                'encodeLabel' => false,
                'items'       => array_merge(
                    array(
                        array(
                            'icon'  => 'question-sign',
                            'label' => Yii::t('YupeModule.yupe', 'Help'),
                            'url'   => CHtml::normalizeUrl(array('/yupe/backend/help')),
                            'items' => array(
                                array(
                                    'icon'  => 'icon-globe',
                                    'label' => Yii::t('YupeModule.yupe', 'Official site'),
                                    'url'   => 'http://yupe.ru?from=help',
                                    'linkOptions' => array('target' => '_blank'),
                                ),
                                array(
                                    'icon'  => 'icon-book',
                                    'label' => Yii::t('YupeModule.yupe', 'Official docs'),
                                    'url'   => 'http://yupe.ru/docs/index.html?from=help',
                                    'linkOptions' => array('target' => '_blank'),
                                ),
                                array(
                                    'icon'  => 'icon-th-large',
                                    'label' => Yii::t('YupeModule.yupe', 'Additional modules'),
                                    'url'   => 'https://github.com/yupe/yupe-ext',
                                    'linkOptions' => array('target' => '_blank'),
                                ),
                                array(
                                    'icon'  => 'icon-comment',
                                    'label' => Yii::t('YupeModule.yupe', 'Forum'),
                                    'url'   => 'http://yupe.ru/talk/?from=help',
                                    'linkOptions' => array('target' => '_blank'),
                                ),
                                array(
                                    'icon'  => 'icon-globe',
                                    'label' => Yii::t('YupeModule.yupe', 'Community on github'),
                                    'url'   => 'https://github.com/yupe/yupe',
                                    'linkOptions' => array('target' => '_blank'),
                                ),
                                array(
                                    'icon'  => 'icon-thumbs-up',
                                    'label' => Yii::t('YupeModule.yupe', 'Order development and support'),
                                    'url'   => 'http://amylabs.ru/contact?from=help-support',
                                    'linkOptions' => array('target' => '_blank'),
                                ),
                                array(
                                    'icon'  => 'icon-warning-sign',
                                    'label' => Yii::t('YupeModule.yupe', 'Report a bug'),
                                    'url'   => CHtml::normalizeUrl(array('/yupe/backend/reportBug/')),
                                    'linkOptions' => array('target' => '_blank'),
                                ),
                                array(
                                    'icon'  => 'exclamation-sign',
                                    'label' => Yii::t('YupeModule.yupe', 'About Yupe!'),
                                    'url'   => array('/yupe/backend/help'),
                                ),
                            )
                        ),
                        array(
                            'icon'        => 'home',
                            'label'       => Yii::t('YupeModule.yupe', 'Go home'),
                            'linkOptions' => array('target' => '_blank'),
                            'visible'     => Yii::app()->controller instanceof yupe\components\controllers\BackController === true,
                            'url'         => array('/' . Yii::app()->defaultController . '/index/'),
                        ),
                        array(
                            'label'       => '
                                <div style="float: left; line-height: 16px; text-align: center; margin-top: -10px;">
                                    <small style="font-size: 80%;">' . Yii::t('YupeModule.yupe', 'Administrator') . '</small><br />
                                    <span class="label">' . Yii::app()->user->nick_name . '</span>
                                </div>',
                            'encodeLabel' => false,
                            'items'       => array(
                                array(
                                    'icon'  => 'user',
                                    'label' => Yii::t('YupeModule.yupe', 'Profile'),
                                    'url'   => CHtml::normalizeUrl((array('/user/userBackend/update', 'id' => Yii::app()->user->getId()))),
                                ),
                                array(
                                    'icon'  => 'off',
                                    'label' => Yii::t('YupeModule.yupe', 'Exit'),
                                    'url'   => CHtml::normalizeUrl(array('/user/account/logout')),
                                ),
                            ),
                        ),
                    ), $this->controller->yupe->getLanguageSelectorArray()
                ),
            ),
        ),
    )
);