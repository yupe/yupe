<?php
/**
 * Отображение для виджета YAdminPanel:
 *
 * @category YupeView
 * @package  YupeCMS
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1 (dev)
 * @link     http://yupe.ru
 *
 **/

/**
 * Добавляем нужные CSS и JS:
 */

$mainAssets = Yii::app()->assetManager->publish(Yii::getPathOfAlias('application.modules.yupe.views.assets'));
Yii::app()->clientScript->registerCssFile($mainAssets . '/css/frontpanel.css');
Yii::app()->clientScript->registerScriptFile($mainAssets . '/js/main.js');

Yii::app()->clientScript->registerScript(
    'yupeToken', 'var actionToken = ' . json_encode(
        array(
            'token'      => Yii::app()->request->csrfTokenName . '=' . Yii::app()->request->csrfToken,
            'url'        => Yii::app()->createAbsoluteUrl('yupe/backend/modulestatus'),
            'message'    => Yii::t('YupeModule.yupe', 'Подождите, идёт обработка вашего запроса'),
            'error'      => Yii::t('YupeModule.yupe', 'Во время обработки вашего запроса произошла неизвестная ошибка'),
            'loadingimg' => CHtml::image(
                Yii::app()->getBaseUrl() . '/web/booster-install/assets/img/progressbar.gif', '', array(
                    'style' => 'width: 100%; height: 20px;',
                )
            ),
            'buttons'    => array(
                'yes'    => Yii::t('YupeModule.yupe', 'Да'),
                'no'     => Yii::t('YupeModule.yupe', 'Отмена'),
            ),
            'messages'   => array(
                'confirm_deactivate'       => Yii::t('YupeModule.yupe', 'Вы уверены, что хотите отключить модуль?'),
                'confirm_activate'         => Yii::t('YupeModule.yupe', 'Вы уверены, что хотите включить модуль?'),
                'confirm_uninstall'        => Yii::t('YupeModule.yupe', 'Вы уверены, что хотите удалить модуль?') . '<br />' . Yii::t('YupeModule.yupe', 'Все данные модуля буду удалены.'),
                'confirm_install'          => Yii::t('YupeModule.yupe', 'Вы уверены, что хотите установить модуль?') . '<br />' . Yii::t('YupeModule.yupe', 'Будут добавлены новые данные для работы модуля.'),
                'confirm_cacheFlush'       => Yii::t('YupeModule.yupe', 'Вы уверены, что хотите удалить весь кеш?'),
                'confirm_assetsFlush'      => Yii::t('YupeModule.yupe', 'Вы уверены, что хотите удалить все ресурсы (assets)?'),
                'confirm_cacheAssetsFlush' => Yii::t('YupeModule.yupe', 'Вы уверены, что хотите удалить весь кеш и все ресурсы (assets)?') . '<br />' . Yii::t('YupeModule.yupe', 'Стоит учесть, что это трудоёмкий процесс и может занять некоторое время!'),
                'unknown'                  => Yii::t('YupeModule.yupe', 'Выбрано неизвестное действие.'),
            )
        )
    ), CClientScript::POS_BEGIN
);

$this->widget(
    'bootstrap.widgets.TbNavbar', array(
        'htmlOptions' => array('class' => 'navbar-inverse'),
        'fluid'       => true,
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
                'items' => $this->controller->yupe->getModules(true),
            ),
            array(
                'class'       => 'bootstrap.widgets.TbMenu',
                'htmlOptions' => array('class' => 'pull-right'),
                'encodeLabel' => false,
                'items'       => array_merge(
                    array(
                        array(
                            'icon'  => 'question-sign white',
                            'label' => Yii::t('YupeModule.yupe', 'Помощь'),
                            'url'   => CHtml::normalizeUrl(array('/yupe/backend/help')),
                            'items' => array(
                                array(
                                    'icon'  => 'icon-globe',
                                    'label' => Yii::t('YupeModule.yupe', 'Официальный сайт'),
                                    'url'   => 'http://yupe.ru?from=help',
                                    'linkOptions' => array('target' => '_blank'),
                                ),
                                array(
                                    'icon'  => 'icon-book',
                                    'label' => Yii::t('YupeModule.yupe', 'Официальная документация'),
                                    'url'   => 'http://yupe.ru/docs/index.html?from=help',
                                    'linkOptions' => array('target' => '_blank'),
                                ),
                                array(
                                    'icon'  => 'icon-comment',
                                    'label' => Yii::t('YupeModule.yupe', 'Форум'),
                                    'url'   => 'http://yupe.ru/talk/?from=help',
                                    'linkOptions' => array('target' => '_blank'),
                                ),
                                array(
                                    'icon'  => 'icon-globe',
                                    'label' => Yii::t('YupeModule.yupe', 'Сообщество на github'),
                                    'url'   => 'https://github.com/yupe/yupe',
                                    'linkOptions' => array('target' => '_blank'),
                                ),
                                array(
                                    'icon'  => 'icon-thumbs-up',
                                    'label' => Yii::t('YupeModule.yupe', 'Заказать разработку'),
                                    'url'   => 'http://yupe.ru/feedback/index?from=help',
                                    'linkOptions' => array('target' => '_blank'),
                                ),
                                array(
                                    'icon'  => 'icon-warning-sign',
                                    'label' => Yii::t('YupeModule.yupe', 'Сообщить об ошибке'),
                                    'url'   => CHtml::normalizeUrl(array('/yupe/backend/reportBug/')),
                                    'linkOptions' => array('target' => '_blank'),
                                ),
                                array(
                                    'icon'  => 'exclamation-sign',
                                    'label' => Yii::t('YupeModule.yupe', 'О Юпи!'),
                                    'url'   => array('/yupe/backend/help'),
                                ),
                            )
                        ),
                        array(
                            'icon'        => 'home white',
                            'label'       => Yii::t('YupeModule.yupe', 'На сайт'),
                            'linkOptions' => array('target' => '_blank'),
                            'visible'     => Yii::app()->controller instanceof YBackController === true,
                            'url'         => array('/' . Yii::app()->defaultController . '/index/'),
                        ),
                        array(
                            'label'       => '
                                <div style="float: left; line-height: 16px; text-align: center; margin-top: -10px;">
                                    <small style="font-size: 80%;">' . Yii::t('YupeModule.yupe', 'Администратор') . '</small><br />
                                    <span class="label">' . Yii::app()->user->nick_name . '</span>
                                </div>',
                            'encodeLabel' => false,
                            'items'       => array(
                                array(
                                    'icon'  => 'user',
                                    'label' => Yii::t('YupeModule.yupe', 'Профиль'),
                                    'url'   => CHtml::normalizeUrl((array('/user/default/update', 'id' => Yii::app()->user->id))),
                                ),
                                array(
                                    'icon'  => 'off',
                                    'label' => Yii::t('YupeModule.yupe', 'Выйти'),
                                    'url'   => CHtml::normalizeUrl(array('/user/account/logout')),
                                ),
                            ),
                        ),
                    ), $this->controller->yupe->languageSelectorArray
                ),
            ),
        ),
    )
);